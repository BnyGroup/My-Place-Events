<div class="container-fluid primary-bg" id="search-filter">
    <div class="container">
        <form method="post" action="{{ route('prestataire') }}" id="list-search-form">
            <div class="form-row">
                <div class="col">
                    {{ csrf_field() }}
                    <input type="text" class="form-control" placeholder="@lang('words.search_bar.search_bar_5')" name="p_name">
                    @if($errors->has('p_name')) <span class="error">{{ $errors->first('p_name') }}</span> @endif
                </div>

                <div class="col form-group">
                    <select class="form-control form-textbox k-state" name="categories" id="categories">
                        <option value="">@lang('words.search_bar.search_bar_4')</option>
                        @foreach ($categories as $key => $values)
 
                                <option value="{!! $values['id'] !!}" @if(Input::old('event_category') ==  $values['id']) selected="selected" @endif >{!! $values->category_name !!}</option>
                            
                        @endforeach
                    </select>
                    @if($errors->has('event_category')) <span class="error">{{ $errors->first('event_category') }}</span> @endif
                </div>
                
                <!-- Select Pays -->

                <div class="col form-group">
                    <select class="form-control form-textbox k-state" name="pays" id="pays">
                        <option value="">Pays</option>
                        <?php  foreach($paysList as $pp){ ?>
                            <option>{{ $pp['nom_pays'] }} </option>
                       <?php } ?>

                    <!-- Une liste d'option de pays existants -->
                    </select>
                    @if($errors->has('event_country')) <span class="error">{{ $errors->first('event_country') }}</span> @endif
                </div>
 
                <!-- Fin Select Pays -->

 
 
    <?php /* ?> <div class="col form-group">
                    <input autocomplete="off" type="text" class="form-control" placeholder="@lang('words.search_bar.search_bar_4')" name="categories" id="forCat" readonly value="@lang('words.search_bar.search_bar_4')">
                    <ul style="text-align: left; position: absolute;background-color: #fff; width: 97%;border-radius:5px;border:solid black 1px;list-style: none; padding: 14px;z-index: 1000; display: none;" id="forCatContent">
                        <a><li>Categories</li></a>
                        @foreach($cat->getCatList() as $categorie)
                            <a><li>{{ $categorie->category_name }}</li></a>
                        @endforeach
                    </ul>
                </div>
                <div class="col form-group">
                    <input autocomplete="off" type="text" class="form-control" placeholder="@lang('words.search_bar.search_bar_2')" name="pays" id="forPays" readonly value="@lang('words.search_bar.search_bar_2')">
                    <ul style="text-align: left; position: absolute;background-color: #fff; width: 97%;border-radius:5px;border:solid black 1px;list-style: none; padding: 14px;z-index: 1000; display: none;" id="forPaysContent">
                    <a><li>Pays</li></a>
                        @foreach ($pays->getCountryList() as $paysLists)
                            <a><li>{{ $paysLists->nom_pays }}</li></a>
                        @endforeach
                    </ul>
                </div><?php */ ?>

                <div class="col">
                    <button type="submit" class="btn btn-primary mb-2 secondary-bg">TROUVEZ UN PRESTATAIRE</button>
                </div>
            </div>
        </form>
    </div>
</div>