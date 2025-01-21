{{--
<div class="container-fluid secondary-bg" id="search-filter">
    <div class="container">
        <form method="post" action="{{ url('events/search-results') }}" id="mobile-home-search-form">
            <div class="form-row">
                <div class="col">
                    {{ csrf_field() }}
                    <input type="text" class="form-control" placeholder="Nom de l'événement" name="e_name">
                     <span class="error"></span>
                    --}}
{{--

                </div>
                <!-- Select Pays -->
                <div class="col form-group">
                    <select class="form-control form-textbox k-state" name="event_country" id="event_country">
                        <option value="">Pays de l'événement</option>
                        @foreach ($countries->getCountryList() as $paysLists)
                            <option>{{ $paysLists->nom_pays }} </option>
                        @endforeach

                    <!-- Une liste d'option de pays existants -->
                    </select>
                </div>
                <!-- Fin Select Pays -->

                <div class="col form-group">
                    <select class="form-control form-textbox k-state" name="event_category" id="event_category">
                        <option value="">Catégories</option>
                        @foreach ($eventCat->get_Category_event() as $key => $values)
                            @if($values->children->isEmpty())
                                <option value="{!! $values['id'] !!}" @if(Input::old('event_category') ==  $values['id']) selected="selected" @endif >{!! $values->category_name !!}</option>
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

                <div class="col form-group">
                    <input autocomplete="off" type="text" class="form-control" placeholder="Date" name="date" id="mobile-forDate" readonly value="Date">
                    <ul style="text-align: left; position: absolute;background-color: #fff;width: 97%;border-radius:5px;border:solid black 1px;list-style: none; padding: 14px;z-index: 1000; display: none;" id="mobile-forDateContent">
                        <a><li>Date</li></a>
                        <a><li>@lang('words.events_tab.today')</li></a>
                        <a><li>@lang('words.events_tab.tomorrow')</li></a>
                        <a><li>@lang('words.events_tab.this_week')</li></a>
                        <a><li>@lang('words.events_tab.this_month')</li></a>
                        <a><li id="mobile-custom_date">@lang('words.events_tab.custom_date')
                            </li></a>
                        <li --}}
{{--id="custom_date"--}}{{--
 class="collapse" style="border:1px solid #eeeeee; padding:5px; text-align: center;">
                            <input type="text" autocomplete="off" name="start_date" id="mobile-start_date" class="form-control form-textbox datetimepicker-input datetimepicker1"  placeholder="@lang('words.events_tab.start_date_p')" style="margin-bottom:5px;" data-toggle="datetimepicker" data-target=".datetimepicker1" />
                            <input type="text" autocomplete="off" name="end_date" id="mobile-end_date" class="form-control form-textbox datetimepicker-input datetimepicker2"  placeholder="@lang('words.events_tab.end_date_p')" style="margin-bottom:5px;" data-toggle="datetimepicker" data-target=".datetimepicker2"/>
                        </li>
                    </ul>
                </div>
                --}}
{{--<div class="col form-group">
                    <select class="form-control form-textbox k-state" name="date" id="date">
                        <option>Date</option>
                        <option>Aujourd'hui</option>
                        <option>Demain</option>
                        <option>Cette semaine</option>
                        <option>Cet mois</option>
                        <option>
                            <i class="fa fa-hand-o-right">Date personnalisée</i>
                            <ul id="custom_date">
                                <li class="collapse" style="border:1px solid #eeeeee; padding:5px; text-align: center;">
                                    <input type="text" autocomplete="off" name="start_date" id="start_date" class="form-control form-textbox datetimepicker-input datetimepicker1"  placeholder="@lang('words.events_tab.start_date_p')" style="margin-bottom:5px;" data-toggle="datetimepicker" data-target=".datetimepicker1" />
                                    <input type="text" autocomplete="off" name="end_date" id="end_date" class="form-control form-textbox datetimepicker-input datetimepicker2"  placeholder="@lang('words.events_tab.end_date_p')" style="margin-bottom:5px;" data-toggle="datetimepicker" data-target=".datetimepicker2"/>
                                </li>
                            </ul>
                        </option>

                    </select>

                </div>--}}{{--


                <div class="col">
                    <button type="submit" class="btn btn-primary mb-2 third-bg"><i class="ti-search">&nbsp;</i>RECHERCHER</button>
                </div>
            </div>
        </form>
    </div>
</div>--}}
<div class="container-fluid secondary-bg" id="search-filter">
    <div class="container">
        <form method="post" action="{{ url('events/search-results') }}" id="mobile-home-search-form">
            <div class="form-row">
                <div class="col">
                    {{ csrf_field() }}
                    <input type="text" class="form-control" placeholder="Nom de l'événement" name="e_name">
                </div>

                <!-- Select Pays -->
                <div class="col form-group">
                    <select class="form-control form-textbox k-state" name="event_country" id="event_country">
                        <option value="">Pays de l'événement</option>
                        @foreach ($countries->getCountryList() as $paysLists)
                            <option>{{ $paysLists->nom_pays }} </option>
                        @endforeach
                    <!-- Une liste d'option de pays existants -->
                    </select>
                </div>
                <!-- Fin Select Pays -->

                <div class="col form-group">
                    <select class="form-control form-textbox k-state" name="event_category" id="event_category">
                        <option value="">Catégories</option>
                        @foreach ($eventCat->get_Category_event() as $key => $values)
                            @if($values->children->isEmpty())
                                <option value="{!! $values['id'] !!}" @if(Input::old('event_category') ==  $values['id']) selected="selected" @endif >{!! $values->category_name !!}</option>
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

                <div class="col form-group">
                    <input autocomplete="off" type="text" class="form-control" placeholder="Date" name="date" id="mobile-forDate" readonly value="Date">
                    <ul style="text-align: left; position: absolute;background-color: #fff;width: 97%;border-radius:5px;border:solid black 1px;list-style: none; padding: 14px;z-index: 1000; display: none;" id="mobile-forDateContent">
                        <a><li>Date</li></a>
                        <a><li>@lang('words.events_tab.today')</li></a>
                        <a><li>@lang('words.events_tab.tomorrow')</li></a>
                        <a><li>@lang('words.events_tab.this_week')</li></a>
                        <a><li>@lang('words.events_tab.this_month')</li></a>
                        <a><li id="mobile-custom_date">@lang('words.events_tab.custom_date')
                            </li></a>
                        <li {{--id="custom_date"--}} class="collapse" style="border:1px solid #eeeeee; padding:5px; text-align: center;">
                            <input type="text" autocomplete="off" name="start_date" id="mobile-start_date" class="form-control form-textbox datetimepicker-input datetimepicker1"  placeholder="@lang('words.events_tab.start_date_p')" style="margin-bottom:5px;" data-toggle="datetimepicker" data-target=".datetimepicker1" />
                            <input type="text" autocomplete="off" name="end_date" id="mobile-end_date" class="form-control form-textbox datetimepicker-input datetimepicker2"  placeholder="@lang('words.events_tab.end_date_p')" style="margin-bottom:5px;" data-toggle="datetimepicker" data-target=".datetimepicker2"/>
                        </li>
                    </ul>
                </div>
                {{--<div class="col form-group">
                    <select class="form-control form-textbox k-state" name="date" id="date">
                        <option>Date</option>
                        <option>Aujourd'hui</option>
                        <option>Demain</option>
                        <option>Cette semaine</option>
                        <option>Cet mois</option>
                        <option>
                            <i class="fa fa-hand-o-right">Date personnalisée</i>
                            <ul id="custom_date">
                                <li class="collapse" style="border:1px solid #eeeeee; padding:5px; text-align: center;">
                                    <input type="text" autocomplete="off" name="start_date" id="start_date" class="form-control form-textbox datetimepicker-input datetimepicker1"  placeholder="@lang('words.events_tab.start_date_p')" style="margin-bottom:5px;" data-toggle="datetimepicker" data-target=".datetimepicker1" />
                                    <input type="text" autocomplete="off" name="end_date" id="end_date" class="form-control form-textbox datetimepicker-input datetimepicker2"  placeholder="@lang('words.events_tab.end_date_p')" style="margin-bottom:5px;" data-toggle="datetimepicker" data-target=".datetimepicker2"/>
                                </li>
                            </ul>
                        </option>

                    </select>

                </div>--}}

                <div class="col">
                    <button type="submit" class="btn btn-primary mb-2 third-bg"><i class="ti-search">&nbsp;</i>RECHERCHER</button>
                </div>
            </div>
        </form>
    </div>
</div>