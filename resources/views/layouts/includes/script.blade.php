</div>
@if(!isset($headerLess) || !$headerLess)
    @if($isSideNavActive)
        @include('layouts.includes.side_nav')
    @endif
@endif
<!-- Flash Message -->
@include('errors.flash_message')

<!-- REQUIRED SCRIPTS -->
@yield('script-top')
<!-- jQuery -->
<script src="{{ asset('public/js/app.js') }}"></script>
@if(!isset($headerLess) || !$headerLess)
    <script src="{{ asset('public/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/plugins/mcustomscrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('public/plugins/slicknav/slicknav.min.js') }}"></script>
@endif
@yield('extra-script')
<script src="{{ asset('public/plugins/flash_message/flash.message.js') }}"></script>
<script src="{{ asset('public/js/custom.js') }}"></script>

@yield('script')

</body>
</html>
