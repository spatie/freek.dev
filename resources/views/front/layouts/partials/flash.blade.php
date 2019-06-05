@if(flash()->message)
    <div class="{{ flash()->class }}">{{ flash()->message }}</div>
@endif
