<div class="print_block">
    <div class="print_item">
        <a href="{{route('locale.reincarcare', session('locale'))}}" title="@lang('print_block.reincarca_title')">
        <div class="print_item_icon">
            <img src="/img/toner50.png" width="50px" alt="@lang('print_block.reincarca')"/>
        </div>
        <div class="print_item_name">
            @lang('print_block.reincarca')
        </div>
        </a>
    </div>
    <div class="print_item">
        <a href="{{route('locale.reparatii_imprimate', session('locale'))}}" title="@lang('print_block.print_repair')">
        <div class="print_item_icon">
            <img src="/img/print_rep50.png" width="50px" alt="@lang('print_block.print_repair')"/>
        </div>
        <div class="print_item_name">
            @lang('print_block.print_repair')
        </div>
        </a>
    </div>
    <div class="print_item">
        <div class="print_item_icon">
            <img src="/img/copy50.png" width="50px" alt="@lang('print_block.copy_repair')"/>
        </div>
        <div class="print_item_name">
            @lang('print_block.copy_repair')
        </div>
    </div>
    <div class="print_item">
        <a href="{{route('locale.specialist', session('locale'))}}" title="@lang('print_block.call_specialist')">
        <div class="print_item_icon">
            <img src="/img/enginer50.png" width="50px" alt="@lang('print_block.call_specialist')"/>
        </div>
        <div class="print_item_name">
            @lang('print_block.call_specialist')
        </div>
        </a>
    </div>
</div>
