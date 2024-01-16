@php $ModuleClasses = [] @endphp
@foreach($routes as $name => $routeGroups)
    @php
        $checkBox = 3;
        $class = '';
    @endphp
    @if(empty(settings('show_fixed_roles')) && $checkBox!=3)
        @continue
    @endif
    <div class="card bg-grey-light my-3 mx-4">
        <div class="card-body">
            <div class="route-group {{$class}}">
                <div class="row">
                    <div class="col-md-12 order-1">
                        <div class="col-md-12">
                            @php $allSubModules = true @endphp
                            @foreach($routeGroups as $groupName=>$permissionLists)
                                <div class="row route-subgroup">
                                    <div class="col-lg-9 col-md-12 pl-5 pl-lg-0 order-1 mb-3 pb-2">
                                        <div class="row">
                                            @php $allItems = true @endphp
                                            @foreach($permissionLists as $permissionName => $routeList)
                                                <div class="col-lg-3 col-md-3 col-sm-6">
                                                    <div class="lf-checkbox">
                                                        @if($checkBox==3)
                                                            {{ Form::checkbox("roles[$name][$groupName][]",$permissionName, isset($role->permissions[$type][$name][$groupName]) ? (in_array($permissionName, $role->permissions[$type][$name][$groupName]) ? true :false) : false ,["class"=>"route-item flat-blue module_action_$name task_action_$groupName", "id"=>"list-$name-$groupName-$permissionName"]) }}
                                                        @endif
                                                        <label class="{{$checkBox==1 ? 'active' : ($checkBox==2 ?'inactive' : '')}}"
                                                               for="list-{{$name}}-{{$groupName}}-{{ $permissionName }}">{{ Str::title(str_replace('_',' ',$permissionName)) }}</label>
                                                    </div>
                                                </div>
                                                @php
                                                    if (!isset($role->permissions[$type][$name][$groupName]) || !in_array($permissionName, $role->permissions[$type][$name][$groupName])) {
                                                        $allSubModules = false;
                                                        $allItems = false;
                                                    }
                                                @endphp
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-12 pl-3 order-0 mb-2">
                                        <div class="lf-checkbox">
                                            @if($checkBox==3)
                                                {{ Form::checkbox("task",1,$allItems,["class"=>"sub-module flat-blue task module_action_$name module_action_{$name}_{$groupName}","id"=>"task-$name-$groupName", "data-id"=>"$groupName"]) }}
                                            @endif
                                            <label class="{{$checkBox==1 ? 'active' : ($checkBox==2 ?'inactive' : '')}}"
                                                   for="task-{{$name}}-{{$groupName}}">{{ Str::title(str_replace('_',' ',$groupName)) }}</label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @if(isset($roleBasedRoutes[$name]) && $name === $role->slug)
                                @foreach($roleBasedRoutes[$name] as $groupName=>$permissionLists)
                                    <div class="row route-subgroup">
                                        <div class="col-lg-9 col-md-12 pl-5 pl-lg-0 order-1 mb-3 pb-2">
                                            <div class="row">
                                                @php $allItems = true @endphp
                                                @foreach($permissionLists as $permissionName => $routeList)
                                                    <div class="col-lg-3 col-md-3 col-sm-6">
                                                        <div class="lf-checkbox">
                                                            <label class="active">{{ Str::title(str_replace('_',' ',$permissionName)) }}</label>
                                                        </div>
                                                    </div>
                                                    @php
                                                        if (!isset($role->permissions[$type][$name][$groupName]) || !in_array($permissionName, $role->permissions[$type][$name][$groupName])) {
                                                            $allSubModules = false;
                                                            $allItems = false;
                                                        }
                                                    @endphp
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-12 pl-3 order-0 mb-2">
                                            <div class="lf-checkbox">
                                                <label class="active">{{ Str::title(str_replace('_',' ',$groupName)) }}</label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endisset
                        </div>
                    </div>

                    <div class="col-12 order-0">
                        <div class="lf-checkbox mb-3">
                            @if($checkBox==3)
                                {{ Form::checkbox("module",1,$allSubModules,["class"=>"flat-blue module module_$name","id"=>"role-$name", "data-id"=>"$name"]) }}
                            @endif
                            <label class="{{$checkBox==1 ? 'active' : ($checkBox==2 ?'inactive' : '')}}"
                                   for="role-{{$name}}">{{ Str::title(str_replace('_',' ',$name)) }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
<div class="card border-0">
    <div class="card-body px-4 text-right">
        {{ Form::reset(__('Reset'),['class'=>'btn btn-danger mr-2 form-submission-button']) }}
        {{ Form::submit($buttonText,['class'=>'btn btn-info form-submission-button']) }}
    </div>
</div>
