@if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" style="direction: rtl" role="alert">
        <strong>{{session()->get("success")}}</strong>
        <button type="button" class="close" style="direction: ltr" data-dismiss='alert' aria-label="Close">
            <span aria-hidden="true" style="direction: ltr">&times;</span>
        </button>
    </div>
@endif

{{-- @if (session()->has('success'))
        <script>
            window.onload = function() {
                notif({
                    msg: {{session()->get("success")}},
                    type: "success"
                })
            }
        </script>
@endif --}}
