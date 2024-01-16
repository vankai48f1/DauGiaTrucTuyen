<div class="card">
    <div class="card-header py-4">
        <h3 class="font-weight-bold d-inline color-666">{{$title}}</h3>
    </div>
    <div class="card-body p-5">

        <!-- Start: auction main content -->
        <div class="form-group form-row">
            {{Form::label('main_content', __('Main Content :'), ['class' => 'col-lg-2 col-form-label text-right pr-3 color-999'])}}
            <div class="col-lg-10">

                <!-- Start: currency type -->
                {{ Form::select('currency_symbol', $currencies, null, ['class' => 'custom-select color-666', 'id' => 'currency_symbol', 'placeholder' =>  __('Select Currency Type')]) }}
                <span class="invalid-feedback"
                      data-name="currency_symbol">{{ $errors->first('currency_symbol') }}</span>
                <!-- End: currency type -->

                <!-- Start: auction type -->
                {{ Form::select('auction_type', auction_type(), null, ['class' => 'custom-select color-666 mt-3', 'id' => 'auction_type', 'placeholder' =>  __('Select Auction Type'), '@change' => 'auctionTypeHandler']) }}
                <span class="invalid-feedback" data-name="auction_type">{{ $errors->first('auction_type') }}</span>
                <!-- End: auction type -->

                <!-- Start: category -->
                {{ Form::select('category_id', $categories, null, ['class' => 'custom-select color-666 mt-3', 'id' => 'category_id', 'placeholder' =>  __('Select Category')]) }}
                <span class="invalid-feedback" data-name="category_id">{{ $errors->first('category_id') }}</span>
                <!-- End: category -->

            </div>

        </div>
        <!-- End: auction main content -->

        <!-- Start: auction main content -->
        <div class="form-group form-row mt-4">
            {{Form::label('auction_about', __('About Auction :'), ['class' => 'col-lg-2 col-form-label text-right pr-3 color-999'])}}

            <div class="col-lg-10">

                <div class="form-row">
                    <div class="col-12">
                        <!-- Start: title -->
                        {{ Form::text('title', null, ['class'=> form_validation($errors, 'title'), 'id' => 'title', 'placeholder' => __('Contest Title')]) }}
                        <span class="invalid-feedback" data-name="title">{{ $errors->first('title') }}</span>
                        <!-- End: title -->
                    </div>
                </div>

                <!-- Start: bid initial price and bid increment difference -->
                <div class="form-row mt-3">

                    <!-- Start: bid initial price -->
                    <div class="col-6">
                        {{ Form::text('bid_initial_price', null, ['class'=> form_validation($errors, 'bid_initial_price'), 'id' => 'bid_initial_price', 'placeholder' => __('Bid Initial Price')]) }}
                        <span class="invalid-feedback"
                              data-name="bid_initial_price">{{ $errors->first('bid_initial_price') }}</span>
                    </div>
                    <!-- End: bid initial price -->

                    <!-- Start: bid increment difference -->
                    <div v-if="showBidIncrement == '{{AUCTION_TYPE_HIGHEST_BIDDER}}'" class="col-6">
                        {{ Form::text('bid_increment_dif', null, ['class'=> form_validation($errors, 'bid_increment_dif'), 'id' => 'bid_increment_dif', 'placeholder' => __('Bid Increment Difference')]) }}
                        <span class="invalid-feedback"
                              data-name="bid_increment_dif">{{ $errors->first('bid_increment_dif') }}</span>
                    </div>
                    <!-- End: bid increment difference -->

                </div>
                <!-- End: bid initial price and bid increment difference -->

                <!-- Start: starting and ending date -->
                <div class="form-row mt-3">
                    <div class="col-6">
                        <!-- Start: starting date -->
                        {{ Form::text('starting_date', isset($auction) ? $auction->starting_date->toDateString() : null, ['class'=> form_validation($errors, 'starting_date'), 'id' => 'start_time','placeholder' => __('Starting Date')]) }}
                        <span class="invalid-feedback"
                              data-name="starting_date">{{ $errors->first('starting_date') }}</span>
                        <!-- End: starting date -->
                    </div>
                    <div class="col-6">
                        <!-- Start: ending date -->
                        {{ Form::text('ending_date', isset($auction) ? $auction->ending_date->toDateString() : null, ['class'=> form_validation($errors, 'ending_date'), 'id' => 'end_time', 'placeholder' => __('Ending Date')]) }}
                        <span class="invalid-feedback"
                              data-name="ending_date">{{ $errors->first('ending_date') }}</span>
                        <!-- End: ending date -->
                    </div>
                </div>
                <!-- End: starting and ending date -->

            </div>

        </div>
        <!-- End: auction main content -->

        <!-- Start: descriptions -->
        <div class="form-group form-row mt-4">
            {{Form::label('main_content', __('Product Description :'), ['class' => 'col-lg-2 col-form-label text-right pr-3 color-999'])}}

            <div class="col-lg-10">

                <!-- Start: description -->
                {{ Form::textarea('product_description', null, ['class'=> form_validation($errors, 'product_description'), 'id' => 'product_description', 'placeholder' => __('Description'), 'rows' => '3']) }}
                <span class="invalid-feedback">{{ $errors->first('product_description') }}</span>
                <!-- End: description -->

            </div>

        </div>
        <!-- End: descriptions -->

        <!-- Start: terms descriptions -->
        <div class="form-group form-row mt-4">
            {{Form::label('terms_description', __('Terms Description :'), ['class' => 'col-lg-2 col-form-label text-right pr-3 color-999'])}}
            <div class="col-lg-10">

                <!-- Start: terms description -->
                {{ Form::textarea('terms_description', null, ['class'=> form_validation($errors, 'terms_description'), 'id' => 'terms_description', 'placeholder' => __('Terms Description'), 'rows' => '3']) }}
                <span class="invalid-feedback">{{ $errors->first('terms_description') }}</span>
                <!-- End: terms description -->
            </div>

        </div>
        <!-- End: terms descriptions -->

        <!-- Start: basic information -->
        <div class="form-group form-row mt-4">
            {{Form::label('is_shippable', __('Shippable :'), ['class' => 'col-lg-2 col-form-label text-right pr-3 color-999'])}}

            <div class="col-md-10">
                <div class="lf-switch">
                    {{ Form::radio('is_shippable', ACTIVE_STATUS_ACTIVE, true, ['id' => 'is_shippable' . '-active', 'class' => 'lf-switch-input', '@click' => 'isShippableHandler']) }}
                    <label for="{{ 'is_shippable'}}-active" class="lf-switch-label">{{ __('Yes') }}</label>

                    {{ Form::radio('is_shippable', ACTIVE_STATUS_INACTIVE,  false, ['id' => 'is_shippable' . '-inactive', 'class' => 'lf-switch-input', '@click' => 'isShippableHandler']) }}
                    <label for="{{ 'is_shippable' }}-inactive" class="lf-switch-label">{{ __('No') }}</label>
                </div>
                <span class="invalid-feedback">{{ $errors->first('is_shippable') }}</span>
            </div>
        </div>
        <!-- End: basic information -->

        <div v-show="showShippingDescription">
            <!-- Start: terms descriptions -->
            <div class="form-group form-row mt-4">
                {{Form::label('shipping_description', __('Shipping Description :'), ['class' => 'col-lg-2 col-form-label text-right pr-3 color-999'])}}
                <div class="col-lg-10">
                    <!-- Start: terms description -->
                    {{ Form::textarea('shipping_description', null, ['class'=> form_validation($errors, 'shipping_description'), 'id' => 'shipping_description', 'placeholder' => __('Shipping Description'), 'rows' => '3']) }}
                    <span class="invalid-feedback">{{ $errors->first('shipping_description') }}</span>
                    <!-- End: terms description -->
                </div>
            </div>
            <!-- End: terms descriptions -->
        </div>

        <!-- Start: basic information -->
        <div class="form-group form-row mt-4">
            {{Form::label('shipping_type', __('Shipping Type :'), ['class' => 'col-lg-2 col-form-label text-right pr-3 color-999'])}}

            <div class="col-md-10">
                <div class="lf-switch">
                    {{ Form::radio('shipping_type', ACTIVE_STATUS_ACTIVE, true, ['id' => 'shipping_type' . '-active', 'class' => 'lf-switch-input',]) }}
                    <label for="{{ 'shipping_type' }}-active" class="lf-switch-label">{{ __('Free') }}</label>

                    {{ Form::radio('shipping_type', ACTIVE_STATUS_INACTIVE, false, ['id' => 'shipping_type' . '-inactive', 'class' => 'lf-switch-input']) }}
                    <label for="{{ 'shipping_type' }}-inactive" class="lf-switch-label">{{ __('Paid') }}</label>
                </div>
                <span class="invalid-feedback">{{ $errors->first('shipping_type') }}</span>
            </div>
        </div>
        <!-- End: basic information -->

        <!-- Start: basic information -->
        <div class="form-group form-row mt-4">
            {{Form::label('is_multiple_bid_allowed', __('Multiple Bid :'), ['class' => 'col-lg-2 col-form-label text-right pr-3 color-999'])}}

            <div class="col-md-10">
                <div class="lf-switch">
                    {{ Form::radio('is_multiple_bid_allowed', ACTIVE_STATUS_ACTIVE, true, ['id' => 'is_multiple_bid_allowed' . '-active', 'class' => 'lf-switch-input',]) }}
                    <label for="{{ 'is_multiple_bid_allowed' }}-active"
                           class="lf-switch-label">{{ __('Allowed') }}</label>

                    {{ Form::radio('is_multiple_bid_allowed', ACTIVE_STATUS_INACTIVE, false, ['id' => 'is_multiple_bid_allowed' . '-inactive', 'class' => 'lf-switch-input']) }}
                    <label for="{{ 'is_multiple_bid_allowed' }}-inactive"
                           class="lf-switch-label">{{ __('Not Allowed') }}</label>
                </div>
                <span class="invalid-feedback">{{ $errors->first('is_multiple_bid_allowed') }}</span>
            </div>
        </div>
        <!-- End: basic information -->

        <!-- Start: product image -->
        <div class="form-group form-row mt-4">
            <label class="col-lg-2 col-form-label text-right pr-3 color-999"
                   for="{{ 'content' }}">{{('Multiple Image :')}}</label>
            <div class="col-lg-10">
                <div id="preview-multi-img">
                    <div class="row" id="TextBoxContainer">
                        @isset($auction)
                            @foreach($auction->images as $image)
                                <div class="col-lg-4 single-image-preview">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new img-thumbnail mb-3">
                                                <img class="img" src="{{auction_image($image)}}" alt="">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists mb-3 img-thumbnail"></div>
                                            <div>
                                        <span class="btn btn-sm btn-outline-success btn-file mr-2">
                                            <span class="fileinput-new">{{__('Select')}}</span>
                                            <span class="fileinput-exists">{{__('Change')}}</span>
                                            {{ Form::file('images[]', ['class'=>'multi-input', 'id' => 'images'])}}
                                            {{ Form::hidden('old_images[]', $image,['class' =>'old_image'])}}
                                        </span>
                                                <a href="#" class="btn btn-sm btn-outline-danger fileinput-exists"
                                                   data-dismiss="fileinput">{{__('Remove')}}</a>
                                                @if(!$loop->first)
                                                    <a href="#" class="btn-outline-danger minus-btn btn remove"><i
                                                            class="fa fa-minus"></i></a>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-lg-4">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new img-thumbnail mb-3">
                                            <img class="img" src="{{auction_image('preview.png')}}" alt="">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists mb-3 img-thumbnail"></div>
                                        <div>
                                        <span class="btn btn-sm btn-outline-success btn-file mr-2">
                                            <span class="fileinput-new">{{__('Select')}}</span>
                                            <span class="fileinput-exists">{{__('Change')}}</span>
                                            {{ Form::file('images[]',null, ['class'=>'multi-input', 'id' => 'images'])}}
                                        </span>
                                            <a href="#" class="btn btn-sm btn-outline-danger fileinput-exists"
                                               data-dismiss="fileinput">{{__('Remove')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endisset
                    </div>
                    <div class="fz-12 color-999"> {{__('Dimension : 600*400px')}}</div>
                    <div class="fz-12 color-999"> {{__('Max upload size : 2MB')}}</div>

                    <button id="btnAdd" type="button" class="btn btn-info mt-3 btn-sm font-size-12"
                            data-toggle="tooltip">{{__('Add Next Image')}}</button>
                </div>
                <span class="invalid-feedback">{{ $errors->first('images.*') }}</span>
            </div>
        </div>
        <!-- End: product image -->

        <!-- Start: meta_description -->
        <div class="form-group form-row mt-4">
            {{Form::label('meta_description', __('Meta Description :'), ['class' => 'col-lg-2 col-form-label text-right pr-3 color-999'])}}

            <div class="col-md-10">
                {{ Form::textarea('meta_description', old('terms_description', isset($auction->meta_description)? $auction->meta_description: null), ['class'=> form_validation($errors, 'meta_description'), 'id' => 'meta_description', 'placeholder' => __('Description'), 'rows' => '3']) }}
                <span class="invalid-feedback">{{ $errors->first('meta_description') }}</span>
            </div>
        </div>
        <!-- End: meta_description -->

        <!-- Start: meta_keywords -->
        <div class="form-group form-row mt-4">
            {{Form::label('meta_keywords', __('Meta Keywords :'), ['class' => 'col-lg-2 col-form-label text-right pr-3 color-999'])}}

            <div class="col-md-10">
                @php($keywords = [])
                @if(old('meta_keywords'))
                    @php($keywords = old('meta_keywords'))
                @elseif(!empty($auction->meta_keywords))
                    @php($keywords = $auction->meta_keywords)
                @endif

                <select name="meta_keywords[]"
                        id="meta_keywords" multiple="multiple" class="custom-select color-666">
                    @if(!empty($keywords))
                        @foreach($keywords as $keyword)
                            <option value="{{ $keyword }}" selected>{{ $keyword }}</option>
                        @endforeach
                    @endif
                </select>
                <span class="invalid-feedback">{{ $errors->first('meta_keywords') }}</span>
            </div>
        </div>
        <!-- End: meta_keywords -->
    </div>

    <div class="card-footer text-muted">
        <button value="Submit Design" type="submit" class="btn btn-info float-right form-submission-button my-2"
                id="two">{{ $buttonText }}</button>
    </div>

</div>

