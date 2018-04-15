<template>

    <div class="col-xs-12 app-content portal_form" v-if="translations">
        <div class="panel panel-default">

            <div class="panel-heading">
                <div>Portal translations</div>
            </div>
            <!-- panel heading -->

            <div class="panel-body">
                <div class="form-horizontal margin_top_20">

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Choose languages</label>

                        <div class="col-sm-10 v_select">
                            <v-select
                                    multiple
                                    placeholder="Select translation languages"
                                    v-model="selectedLanguages"
                                    :options="languages">
                            </v-select>
                        </div>
                    </div>
                    <!-- languages section -->

                    <template v-if="selectedLanguages.length > 0">

                        <div class="row">
                            <div class="col-sm-offset-2 col-sm-10">
                                <hr/>
                            </div>
                        </div>
                        <!-- hr -->

                        <div class="form-group">


                            <label class="col-sm-2 control-label">Translations</label>

                            <div class="col-sm-10">

                                <div class="add_bttn_absolute" style="right: 15px;">
                                    <button class="btn btn-primary with_cursor" @click="addTranslationField">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                                <!-- new translation button -->

                                <ul class="nav nav-tabs">
                                    <li v-for="(language, langIdx) in selectedLanguages"
                                        :class="langIdx == 0 ? 'active' : ''">
                                        <a data-toggle="tab" :href="'#s_page' + langIdx">
                                            {{ language.label }}
                                        </a>
                                    </li>
                                </ul>
                                <!-- nav-tabs headers -->

                                <div class="tab-content">
                                    <div :id="'s_page' + langIdx" class="tab-pane"
                                         v-for="(language, langIdx) in selectedLanguages"
                                         :class="langIdx == 0 ? 'in active' : ''">

                                        <div class="form-group truukske" v-for="(translation, idx) in translations">

                                            <div class="col-sm-2">
                                                <input type="text" autocomplete="off" class="form-control bold"
                                                       v-model="translation.key" placeholder="Type a key"
                                                       :disabled="translation.in_use == 1">
                                            </div>

                                            <div class="col-sm-10">
                                                <input type="text" autocomplete="off"
                                                       class="form-control width_100_minus_bttn pull-left"
                                                       v-model="translation.text[language.value]"
                                                       :placeholder="language.label + ' translation for the key ' + translation.key">

                                                <tooltip class="pull-right"
                                                         content="This translation is marked as<br>'IN USE' and can not be deleted"
                                                         style="position: relative;display:block;"
                                                         v-if="translation.in_use == 1">
                                                    <div class="btn btn-danger" style="opacity: 0.2">
                                                        <i class="fa fa-times"></i>
                                                    </div>
                                                </tooltip>

                                                <div class="btn btn-danger pull-right" @click="removeTranslation(idx)"
                                                     v-if="translation.in_use == 0">
                                                    <i class="fa fa-times"></i>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- form-group -->


                                    </div>
                                </div>
                                <!-- end tab-content -->


                                <div class="form-group">
                                    <div class="add_bttn_absolute" style="right: 15px;margin-top: -2px;">
                                        <button class="btn btn-primary with_cursor" @click="addTranslationField">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                    <!-- new translation button -->
                                </div>

                            </div>
                        </div>
                        <!-- form-group -->

                    </template>

                    <div class="form-group margin_top_40">
                        <div class="col-sm-offset-2 col-sm-10 text-right">

                            <button class="btn btn-success min_width_100"
                                    @click="save(true)"
                                    :class="helpers.spinner.saveAndReturn || helpers.spinner.save ? 'disabled' : ''">
                                <span v-show="!helpers.spinner.saveAndReturn">Save & return</span>
                                <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw bttn_spinner"
                                   v-show="helpers.spinner.saveAndReturn"></i>
                            </button>

                            <button class="btn btn-success min_width_100"
                                    @click="save()"
                                    :class="helpers.spinner.saveAndReturn || helpers.spinner.save ? 'disabled' : ''">
                                <span v-show="!helpers.spinner.save">Save</span>
                                <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw bttn_spinner"
                                   v-show="helpers.spinner.save"></i>
                            </button>

                        </div>
                    </div>
                    <!-- save section -->

                </div>
                <!-- main form -->
            </div>
            <!-- panel-body -->
        </div>
        <!-- panel-default -->
    </div>
    <!-- portal_form -->

</template>

<script>
    import {tabs, tab, tabGroup, tabset, modal, select, tooltip} from 'vue-strap';
    import _ from 'lodash';

    export default {

        components: {
            tabs, tab, tabGroup, tabset, modal, vSelect2: select, tooltip
        },

        props: {
            languages: {},
            translations_: {}
        },

        data() {
            return {

                translations: [],

                selectedLanguages: [],

                helpers: {
                    spinner: {
                        save: false,
                        saveAndReturn: false
                    }
                }
            }
        },

        mounted() {
            if (this.translations_.length) {
                this.translations = this.translations_;

                this.languages.forEach((language) => {
                    if (this.translations[0].text.hasOwnProperty(language.value)) {
                        this.selectedLanguages.push(language);
                    }
                });
            }
        },

        computed: {},

        methods: {

            addTranslationField() {

                var translation = {
                    id: 0,
                    content_portal_theme_id: 1,
                    group: 'portal',
                    key: 'key_name',
                    in_use: 0,
                    text: {}
                };

                // fill label with keys of selected languages
                this.selectedLanguages.forEach((language) => {
                    this.$set(translation.text, language.value, "");
                });

                this.translations.push(translation);
            },

            removeTranslation(idx) {
                this.translations.splice(idx, 1);
            },

            save(goBack) {

                goBack ? this.helpers.spinner.saveAndReturn = true : this.helpers.spinner.save = true;

                axios.post('/admin/api/translations/', {translations: this.translations})
                    .then((response) => {
                        if (response.data) {
                            this.helpers.spinner.save = false;
                            this.helpers.spinner.saveAndReturn = false;
                            if (goBack) window.location.href = '/admin/translations';
                        }
                    });
            }
        },

        watch: {
            'selectedLanguages': function (languages) {
                var me = this;

                // loop selected languages and add it to labels if not allready exists (hasownproperty...)
                languages.forEach((language) => {
                    if (me.translations.length && !me.translations[0].text.hasOwnProperty(language.value)) {

                        me.translations.forEach((translation) => {
                            me.$set(translation.text, language.value);
                        });

                    }
                });
            }
        }
    }
</script>
