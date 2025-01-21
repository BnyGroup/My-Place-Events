 
<form method="post" action="{{ route('events.search-results') }}" id="home-searchpanel-form">
    <i class="fas fa-times close-icon" onclick="closeFormAndReload()"></i>

    <div class="form-row" style="padding: 20px;">
        <div class="form-group">
            {{ csrf_field() }}
            <input type="text" class="form-control" placeholder="@lang('words.search_bar.search_bar_1')" name="e_name">
        </div>

        <!-- Select Pays -->
        <div class=" form-group">
            <select class="form-control form-textbox k-state" name="event_country" id="event_country">
                <option value="">@lang('words.search_bar.search_bar_2')</option>  
                @foreach ($countries->getCountryList() as $paysLists)
                    <option value="<?php echo $paysLists->nom_pays; ?>" <?php if($paysLists->id_pays==10) echo'selected'; ?>>{{ $paysLists->nom_pays }} </option>
                @endforeach

            <!-- Une liste d'option de pays existants -->
            </select>
        </div>
        <!-- Fin Select Pays -->

        <div class=" form-group">
            <select class="form-control form-textbox k-state" name="event_category" id="event_category">
                <option value="">@lang('words.search_bar.search_bar_4')</option>
                @foreach ($eventCat->get_Category_event() as $key => $values)
                    @if($values->children->isEmpty())
                            <option value="{!! $values['id'] !!}" 
									<?php if(isset($_POST['event_category'])){
										if($_POST['event_category'] ==  $values['id']){ echo'selected="selected"'; }
									} ?> >{!! $values->category_name !!}</option>
                    @else
                    @foreach ($values->children as $value)
                                <option value="{!! $value['id'] !!}" @if(Input::old('event_category') ==  $value['id']) selected="selected" @endif >
                                    {!! $value->category_name !!}
                                </option>
                            @endforeach
                        @endif
             	 @endforeach
            </select>
        </div>

        <div class="form-group">
            <input autocomplete="off" type="text" class="form-control" placeholder="Date" name="date" id="forDate" readonly value="Date">
            <ul style="text-align: left; position: absolute;background-color: #fff;width: 97%;border-radius:5px;border:solid black 1px;list-style: none; padding: 14px;z-index: 1000; display: none;" id="forDateContent">
                <a><li>Date</li></a>
                <a><li>@lang('words.events_tab.today')</li></a>
                <a><li>@lang('words.events_tab.tomorrow')</li></a>
                <a><li>@lang('words.events_tab.this_week')</li></a>
                <a><li>@lang('words.events_tab.this_month')</li></a>
                <a><li id="custom_date">@lang('words.events_tab.custom_date')
                    </li></a>
                <li id="custom_date" class="collapse" style="border:1px solid #eeeeee; padding:5px; text-align: center;">
                    <input type="text" autocomplete="off" name="start_date" id="start_date" class="form-control form-textbox datetimepicker-input datetimepicker1"  placeholder="@lang('words.events_tab.start_date_p')" style="margin-bottom:5px;" data-toggle="datetimepicker" data-target=".datetimepicker1" />
                    <input type="text" autocomplete="off" name="end_date" id="end_date" class="form-control form-textbox datetimepicker-input datetimepicker2"  placeholder="@lang('words.events_tab.end_date_p')" style="margin-bottom:5px;" data-toggle="datetimepicker" data-target=".datetimepicker2"/>

                </li>
            </ul>
        </div> 

        <div class="form-group">
            <button type="submit" class="btn btn-primary mb-2 third-bg"><i class="ti-search">&nbsp;</i>@lang('words.search_bar.search_bar_3')</button>
        </div>
    </div>
</form>
<script>
    function closeFormAndReload() {
        document.getElementById('home-searchpanel-form').style.display = 'none';
        window.location.reload(); // recharge la page
    }
</script>