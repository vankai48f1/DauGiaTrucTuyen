@extends('layouts.master')

@section('title', $title)

@section('content')
    <div class="container my-5 lf-languge-palet">
        <div class="row">
            <div class="col-md-12">
                <div class="bg-light py-3 px-3">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-info dropdown-toggle"
                                data-toggle="dropdown"
                                aria-expanded="false">
                            @{{ selectedLanguage | uppercase }}
                            <span class="caret"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-left" role="menu">
                            <a :class="selectedLanguage == language ? 'dropdown-item active' : 'dropdown-item' "
                               v-for="language in languages" href="javascript:"
                               @click="changeLanguage(language)">
                                @{{ language | uppercase }}
                            </a>
                        </div>

                        <div class="float-right">
                            <button @click="add"
                                    class="btn btn-sm btn-success">{{ __('Add New') }}
                            </button>
                            <button @click="sync"
                                    class="btn btn-sm btn-warning">{{ __('Sync') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-3 lf-bg-grey-light">
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="input-group mb-3 pr-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-search"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" v-model="searchPhrase"
                                   @keyup="searchTranslations" placeholder="Search">
                        </div>

                        <div id="setting-scroll" class="cm-mt-15">
                            <div class="list-group list-group-flush" v-if="Object.keys(filteredTranslations).length">
                                <div v-for="(value, key) in filteredTranslations"
                                     @click="selectedKey = key;addNewKey = false"
                                     :class="['list-group-item', 'list-group-item-action','lf-cursor-pointer','pl-3', {'list-group-item-danger': !value}]">
                                    <div class="d-flex w-100 justify-content-between">
                                        <strong class="mb-1" v-html="highlight(key)"></strong>
                                    </div>
                                    <small class="text-muted" v-html="highlight(value)"></small>
                                </div>
                            </div>
                            <div class="text-center" v-else>
                                <span>{{ __("No translation match with your search key.") }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div v-if="addNewKey">
                            <input type="text" class="form-control" placeholder="{{ __('New Key...') }}"
                                   v-model="newKey">
                            <span class="help-block text-red">@{{ newKeyErrorMsg }}</span>

                            <textarea name="" rows="10" class="form-control my-3"
                                      v-model="newKeyValue"
                                      placeholder="Translate..."></textarea>
                            <span class="help-block text-red">@{{ newKeyValueErrorMsg }}</span>

                            <div class="cm-mt-15">
                                <button class="btn btn-sm btn-primary btn-sm"
                                        @click="saveNewKey">{{ __('Save') }}
                                </button>
                            </div>
                        </div>
                        <div v-else>
                            <div v-if="selectedKey">
                                <p class="mb-4" v-html="highlight(selectedKey)"></p>

                                <textarea name="" rows="10" class="form-control mb-4"
                                          v-model="translations[selectedLanguage][selectedKey]"
                                          @keyup="changeTranslations(selectedKey, $event)"
                                          placeholder="Translate..."></textarea>

                                <div class="cm-mt-15">
                                    <button class="btn btn-sm btn-primary btn-sm"
                                            @click="save">{{ __('Save') }}
                                    </button>
                                    <button class="btn btn-sm btn-danger btn-sm"
                                            @click="remove">{{ __('Delete') }}
                                    </button>
                                </div>
                            </div>

                            <h6 class="text-muted text-center mt-5" v-else>
                                {{ __('Select a key from the list to the left') }}
                            </h6>
                        </div>
                    </div>
                </div>

                <confirmation-dialog
                    :messages="{
                        title: '{{ __("Are you sure you want to delete this key?") }}',
                        cancelButtonText: '{{ __("Cancel") }}',
                        confirmButtonText: '{{ __("Confirm") }}'
                        }"

                    v-if='confirmDialog' @confirm='confirmDelete'
                    @cancel="cancelDelete"></confirmation-dialog>
            </div>

        </div>
    </div>
@endsection
@section('style')
    <style>

        .mCSB_container_wrapper > .mCSB_container {
            padding-right: 0 !important;
        }

        .mCSB_container_wrapper {
            margin-right: 20px !important;
        }

    </style>
@endsection
@section('script')
    <script>
        (function ($){
            "use strict";

            $(window).on("load", function () {
                $("#setting-scroll").mCustomScrollbar({
                    setHeight: "500px",
                    axis: "yx",
                    theme: "dark",
                    scrollInertia: 200
                });
            });
        })(jQuery);

        // vue initial data
        const data = {
            languages: @json(language_short_code_list()),
            selectedLanguage: '{{ app()->getLocale() }}'.toLowerCase(),
            newKeyError: "{{ __('This new key field is required') }}",
            newKeyValueError: "{{ __('This new key value field is required') }}",
            routes: {
                getTranslations: '{{ route("languages.translations") }}',
                update: '{{ route("languages.update.settings") }}',
                sync: '{{ route("languages.sync") }}'
            }
        };
    </script>
    <script src="{{ asset('public/js/language.js') }}?t={{ time() }}"></script>
@endsection


