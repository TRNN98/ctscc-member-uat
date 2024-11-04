<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3">
            <label class="login2 pull-right pull-right-pro">
                @if ($topic)
                    {{ $topic }}
                @else
                    หัวข้อเรื่อง :
                @endif
            </label>
        </div>
        <div class="col-lg-7">
            <input type="text" class="form-control" name="QTitle"
                value="{{ $Question }}" required />
        </div>
        {{-- <div class="col-lg-2">
            @if($_GET['Category'] == 'ebook')
            <font color="#FF0000">เช่น http://www.domain.com/fileEBook
            </font>
            @endif
        </div> --}}
    </div>
</div>
