<div onclick='{{isset($redirectTo) ? "redirect(`$redirectTo`)" : ""}}' class="card card-shadow enumerable {{isset($redirectTo) ? 'redirect' : ''}} {{isset($color) ? $color : ''}}">
    <div class="card-header">
        {{$title}}
    </div>
    <div {{isset($id) ? "id=$id" : ''}} class="card-body">
        {{$value}}
    </div>
</div>