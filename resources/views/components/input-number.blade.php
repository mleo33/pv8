<div class="d-inline">
    <input wire:model.lazy="{{$model}}" onclick="this.select()" onkeypress="return event.charCode >= 46 && event.charCode <= 57"  type="text" class="form-control" style="text-align: {{$align}};"/>
</div>