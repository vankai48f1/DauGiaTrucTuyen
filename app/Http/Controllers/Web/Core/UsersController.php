<?php

namespace App\Http\Controllers\Web\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\UserRequest;
use App\Http\Requests\Core\UserStatusRequest;
use App\Mail\Core\AccountCreated;
use App\Models\Core\Notification;
use App\Models\Core\Role;
use App\Models\Core\User;
use App\Services\Core\DataTableService;
use App\Services\Core\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    public function index()
    {
        $searchFields = [
            ['username', __('Username')],
            ['email', __('Email')],
            ['first_name', __('First Name'), 'profile'],
            ['last_name', __('Last Name'), 'profile'],
            ['slug', __('Role'), 'role'],
        ];
        $orderFields = [
            ['first_name', __('First Name'), 'profile'],
            ['last_name', __('Last Name'), 'profile'],
            ['email', __('Email')],
            ['username', __('Username')],
            ['slug', __('Role'), 'role'],
            ['created_at', __('Registered Date')],
        ];

        $filterFields = [
            ['assigned_role', __('Role'), Role::pluck('name', 'slug')->toArray()],
            ['status', __('Status'), account_status()]
        ];

        $queryBuilder = User::with(["profile:user_id,first_name,last_name"])
            ->orderBy('created_at', 'desc');

        $downloadableHeadings = [
            ['id', __('ID')],
            ['username', __('Username')],
            ['first_name', __('First Name'), 'profile'],
            ['last_name', __('Last Name'), 'profile'],
            ['email', __('Email')],
            ['is_email_verified', __('Email Verified Status')],
            ['is_financial_active', __('Financial Status')],
            ['status', __('Status')]
        ];

        $data['dataTable'] = app(DataTableService::class)
            ->setSearchFields($searchFields)
            ->setOrderFields($orderFields)
            ->setFilterFields($filterFields)
            ->downloadable($downloadableHeadings)
            ->create($queryBuilder);

        $data['title'] = __('Users');
        return view('core.users.index', $data);
    }

    public function show(User $user)
    {
        $data['user'] = $user;
        $data['title'] = __('View User');

        return view('core.users.show', $data);
    }

    public function create()
    {
        $data['roles'] = Role::active()->pluck('name', 'slug')->toArray();
        $data['title'] = __('Create User');

        return view('core.users.create', $data);
    }

    public function store(UserRequest $request)
    {
        $parameters = $request->only(['first_name', 'last_name', 'address', 'assigned_role', 'email', 'username', 'is_email_verified', 'is_financial_active', 'status', 'is_accessible_under_maintenance']);
        $parameters['password'] = random_string('6');
        $parameters['created_by'] = Auth::id();
        if ($user = app(UserService::class)->generate($parameters)) {
            Mail::to($user->email)->send(new AccountCreated($user->profile, $parameters['password']));
            return redirect()->route('admin.users.show', $user->id)->with(RESPONSE_TYPE_SUCCESS, __("User has been created successfully."));
        } else {
            return redirect()->back()->withInput()->with(RESPONSE_TYPE_ERROR, __('Failed to create user.'));
        }
    }

    public function edit(User $user)
    {
        $data['user'] = $user;
        $data['roles'] = Role::active()->pluck('name', 'slug')->toArray();
        $data['title'] = __('Edit User');

        return view('core.users.edit', $data);
    }

    public function update(UserRequest $request, User $user)
    {
        if (!$user->is_super_admin && $user->id != Auth::id()) {
            $parameters['assigned_role'] = $request->assigned_role;
            $notification = ['user_id' => $user->id, 'message' => __("Your account's role has been changed by admin.")];
            $user->update($parameters);
        }

        $parameters = $request->only('first_name', 'last_name', 'address');

        if ($user->profile()->update($parameters)) {
            if (isset($notification)) {
                Notification::create($notification);
            }

            return redirect()->back()->with(RESPONSE_TYPE_SUCCESS, __('User has been updated successfully.'));
        }

        return redirect()->back()->withInput()->with(RESPONSE_TYPE_ERROR, __('Failed to update user'));
    }

    public function editStatus(User $user)
    {
        $data['user'] = $user->load('profile');
        $data['title'] = __('Edit User Status');

        return view('core.users.edit_status', $data);
    }

    public function updateStatus(UserStatusRequest $request, User $user)
    {
        if ($user->id == Auth::id()) {
            return redirect()->route('admin.users.edit.status', $user->id)->with(RESPONSE_TYPE_WARNING, __('You cannot change your own status.'));
        } elseif ($user->is_super_admin) {
            return redirect()->route('admin.users.edit.status', $user->id)->with(RESPONSE_TYPE_WARNING, __("You cannot change primary user's status."));
        }

        $messages = [
            'is_email_verified' => __('Your email verification status has been changed by admin.'),
            'is_financial_active' => __("Your account's financial status has been changed by admin."),
            'is_accessible_under_maintenance' => __("Your account's maintenance mode access has been changed by admin."),
            'status' => __("Your account's status has been changed by admin."),
        ];

        $fields = array_keys($messages);
        $parameters = $request->only($fields);

        if (!$user->update($parameters)) {
            return redirect()->back()->withInput()->with(RESPONSE_TYPE_ERROR, __('Failed to update user status.'));
        }

        $date = date('Y-m-d H:s:i');
        $notifications = [];

        foreach ($fields as $field) {
            if ($user->{$field} != $parameters[$field]) {
                $notifications[] = ['user_id' => $user->id, 'message' => $messages[$field], 'created_at' => $date, 'updated_at' => $date];
            }
        }

        if (!empty($notifications)) {
            Notification::insert($notifications);
        }

        return redirect()->route('admin.users.edit.status', $user->id)->with(RESPONSE_TYPE_SUCCESS, __('User status has been updated successfully.'));
    }
}
