<template>
    <div class="col-xs-12 app-content portal_form">
        <div class="panel panel-default">


            <div class="panel-heading">
                <div>
                    <template v-if="id == 0">
                        Create portal
                    </template>
                    <template v-else>
                        Edit portal - {{ form.title }}
                    </template>
                </div>
            </div>
            <!-- panel heading -->

            <div class="panel-body">

                <form class="form-horizontal margin_top_20" role="form" @submit.prevent="submitForm">


                    <div class="form-group">
                        <label class="col-sm-2 control-label">Portal name</label>

                        <div class="col-sm-10">
                            <input type="text" autocomplete="off" class="form-control" placeholder="Type a name"
                                   v-model="form.title">
                        </div>
                    </div>
                    <!-- portal name section -->


                    <div class="form-group">
                        <label class="col-sm-2 control-label">Portal domain</label>

                        <div class="col-sm-3 column_padding_right_zero">
                            <input type="text" autocomplete="off" class="form-control"
                                   placeholder="Optional subdomain name (e.g. apps)" v-model="form.subdomain">
                        </div>

                        <div class="col-sm-7">
                            <input type="text" autocomplete="off" class="form-control"
                                   placeholder="Type a domain name (e.g. portal.com)" v-model="form.host">
                        </div>
                    </div>
                    <!-- domain section -->


                    <div class="form-group">
                        <label class="col-sm-2 control-label">Languages</label>

                        <div class="col-sm-10 v_select">
                            <v-select
                                    multiple
                                    placeholder="Select portal languages"
                                    v-model="form.languages"
                                    :options="languages">
                            </v-select>
                        </div>
                    </div>
                    <!-- languages section -->


                    <template v-if="form.languages.length > 0">


                        <div class="form-group">
                            <label class="col-sm-2 control-label">Default language</label>

                            <div class="col-sm-10 v_select">
                                <v-select
                                        placeholder="Which language needs to be shown, when there is no language matched for the user?"
                                        v-model="form.default_language"
                                        :options="form.languages">
                                </v-select>
                            </div>
                        </div>
                        <!-- languages section -->

                        <div class="row">
                            <div class="col-sm-offset-2 col-sm-10">
                                <hr/>
                            </div>
                        </div>
                        <!-- hr -->


                        <div class="form-group">
                            <label class="col-sm-2 control-label">Available content types</label>

                            <div class="col-sm-10 v_select">
                                <v-select
                                        multiple
                                        placeholder="Select content types"
                                        v-model="form.localContentTypes"
                                        label="name"
                                        :options="localContentTypes">
                                </v-select>
                            </div>
                        </div>
                        <!-- content types section -->

                        <div class="row">
                            <div class="col-sm-offset-2 col-sm-10">
                                <hr/>
                            </div>
                        </div>
                        <!-- hr -->


                        <div class="form-group margin_top_20">
                            <label class="col-sm-2 control-label">Featured apps</label>
                            <div class="col-sm-10">

                                <featured-app
                                        :form="form"
                                        :featuredModal="featuredModal">
                                </featured-app>

                            </div>
                        </div>
                        <!-- featured apps section -->


                        <div class="row">
                            <div class="col-sm-offset-2 col-sm-10">
                                <hr/>
                            </div>
                        </div>
                        <!-- hr -->


                        <div class="form-group">
                            <label class="col-sm-2 control-label padding_top_10">Content</label>
                            <div class="col-sm-10">

                                <static-pages
                                        :form="form"
                                        :froalaConfig="froalaConfig">
                                </static-pages>

                            </div>
                            <!-- col-sm -->
                        </div>
                        <!-- static pages section -->


                        <div class="row">
                            <div class="col-sm-offset-2 col-sm-10">
                                <hr/>
                            </div>
                        </div>
                        <!-- hr -->


                        <div class="form-group">
                            <label class="col-sm-2 control-label padding_top_10">Footer pages</label>
                            <div class="col-sm-10">

                                <dynamic-pages
                                        :form="form"
                                        :froalaConfig="froalaConfig">
                                </dynamic-pages>

                            </div>
                            <!-- col-sm -->
                        </div>
                        <!-- form-group Pages section -->


                        <div class="row">
                            <div class="col-sm-offset-2 col-sm-10">
                                <hr/>
                            </div>
                        </div>
                        <!-- hr -->

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Show welcome page</label>

                            <div class="col-sm-10">
                                <v-select
                                        v-model="form.options.show_welcome_page"
                                        :options="helpers.yesNo"
                                        placeholder="Select an option"
                                ></v-select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Show cancel option</label>

                            <div class="col-sm-10">
                                <v-select
                                        v-model="form.options.show_cancel_page"
                                        :options="helpers.yesNo"
                                        placeholder="Select an option"
                                ></v-select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Offer URL</label>

                            <div class="col-sm-10">
                                <input type="text" autocomplete="off" class="form-control"
                                       placeholder="(Optional) Type an offer URL" v-model="form.offer_url">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label">Exit URL</label>

                            <div class="col-sm-10">
                                <input type="text" autocomplete="off" class="form-control"
                                       placeholder="(Optional) Type an exit URL" v-model="form.exit_url">
                            </div>
                        </div>


                    </template>
                    <!-- show if has languages -->


                    <div class="form-group margin_top_40">
                        <div class="col-sm-offset-2 col-sm-10 text-right">

                            <button class="btn btn-default min_width_100 pull-left" @click="goBack">
                                Cancel
                            </button>

                            <button class="btn btn-success min_width_100"
                                    @click="save(true)"
                                    :class="helpers.spinner.saveAndReturn || helpers.spinner.save ? 'disabled' : ''">
                                Save & return
                                <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw bttn_spinner"
                                   v-show="helpers.spinner.saveAndReturn"></i>
                            </button>

                            <button class="btn btn-success min_width_100"
                                    @click="save()"
                                    :class="helpers.spinner.saveAndReturn || helpers.spinner.save ? 'disabled' : ''">
                                Save
                                <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw bttn_spinner"
                                   v-show="helpers.spinner.save"></i>
                            </button>

                        </div>
                    </div>
                    <!-- save section -->


                </form>
            </div>
            <!-- panel-body -->
        </div>
        <!-- panel -->
    </div>
    <!-- portal-form -->
</template>

<script>
    import {tabs, tab, tabGroup, tabset, modal, select} from 'vue-strap'
    import FeaturedApp from './FeaturedApp.vue'

    import _ from 'lodash'

    export default {
        components: {
            tabs, tab, tabGroup, tabset, FeaturedApp, modal, vSelect2: select
        },
        props: {
            localContentTypes: Array,
            languages: Array,
            id: {
                type: Number,
                default: 0
            },
        },
        data() {
            return {
                froalaConfig: {
                    toolbarButtons: ['fullscreen', '|', 'bold', 'italic', 'strikeThrough', 'underline', '|', 'paragraphFormat', 'paragraphStyle', 'align', 'formatOL', 'formatUL', 'indent', 'outdent', '|', 'insertLink', 'insertVideo', 'insertFile', 'html'],
                    pluginsEnabled: ['fullscreen', 'align', 'link', 'table', 'paragraphFormat', 'paragraphStyle', 'quote', 'lists', 'fontFamily'],
                    heightMin: 400
                },
                helpers: {
                    spinner: {
                        save: false,
                        saveAndReturn: false
                    },
                    yesNo: [
                        {value: false, label: 'No'},
                        {value: true, label: 'Yes'}
                    ]
                },
                featuredModal: {
                    show: false,
                    contentItems: [],
                    contentItem: '',
                    featuredApp: {
                        content_item_title: '',
                        content_item_id: '',
                        banner: '',
                        created_at: '',
                        visible: 1
                    }

                },
                staticPageTypes: ['price-banner', 'slider', /*'home',*/ 'disclaimer'/*, 'footer'*/],
                form: {
                    title: '',
                    subdomain: '',
                    host: '',
                    default_language: '',
                    localContentTypes: [],
                    languages: [],
                    languagesShort: [],
                    featuredApps: [],
                    staticPages: [],
                    pages: [],
                    offer_url: '',
                    exit_url: '',

                    options: {
                        // default values for filling purposes
                        show_cancel_page: {value: false, label: 'Yes'},
                        show_welcome_page: {value: false, label: 'No'}
                    }
                }
            }
        },

        mounted() {

            if (this.id > 0) {
                this.fetchData();
            }
        },

        methods: {

            fetchData() {
                axios.get('/admin/api/portal/' + this.id)
                    .then(response => {
                        let portal = response.data;
                        console.log(portal);

                        this.form.title = portal.title;
                        this.form.host = portal.host;
                        this.form.languagesShort = response.data.languages;
                        this.form.subdomain = portal.subdomain;
                        this.form.offer_url = portal.offer_url;
                        this.form.exit_url = portal.exit_url;
                        this.form.options = portal.options;

                        if (portal.default_language) {
                            this.form.default_language = this.findLanguageByCode(portal.default_language);
                        }

                        response.data.languages.forEach((language) => {
                            this.form.languages.push(this.findLanguageByCode(language));
                        });

                        // if (portal.disclaimer) {
                        //     _.forEach(portal.disclaimer, function(disclaimer) {
                        //         console.log(disclaimer);
                        //     });
                        // }

                        if (portal.local_content_types) {
                            portal.local_content_types.forEach((localContentType) => {
                                this.form.localContentTypes.push(this.findContentTypeById(localContentType.id));
                            });
                        }

                        if (portal.featured_items) {
                            portal.featured_items.forEach((featuredItem) => {
                                var featuredApp = {
                                    content_item_id: featuredItem.pivot.content_item_id,
                                    content_item_title: featuredItem.titleTranslated,
                                    banner: featuredItem.pivot.banner,
                                    created_at: featuredItem.created_at,
                                    visible: featuredItem.pivot.visible
                                }
                                this.form.featuredApps.push(featuredApp);
                            });
                        }

                        if (portal.pages) {
                            portal.pages.forEach((page) => {
                                page.showModal = false;
                                if (page.type == "dynamic") {
                                    this.form.pages.push(page);
                                }
                                else {
                                    this.form.staticPages.push(page);
                                }

                            });
                        }
                    });
            },

            submitForm() {
                // console.log(this.form);

                // if (this.id == 0) {
                //     this.createPortal(this.form);
                // } else {
                //     this.editPortal(this.form);
                // }
            },

            findLanguageByCode(code) {
                return _.find(this.languages, (lang) => lang.value === code);
            },

            findContentTypeById(id) {
                return _.find(this.localContentTypes, (localContentType) => localContentType.value === id);
            },

            editPortal() {
                axios.patch('/admin/api/portal/3', this.form)
                    .then((response) => {
                        console.log(response);
                    });
            },

            save(goBack) {

                goBack ? this.helpers.spinner.saveAndReturn = true : this.helpers.spinner.save = true;

                this.form.languagesShort = _.map(this.form.languages, 'value');

                if (this.id) {
                    axios.patch('/admin/api/portal/' + this.id, {form: this.form})
                        .then((response) => {
                            if (response.data) {
                                this.helpers.spinner.save = false;
                                this.helpers.spinner.saveAndReturn = false;
                                if (goBack) this.goBack()
                                else window.location.href = '/admin/portal/' + this.id + '/edit';
                            }
                        });
                } else {
                    axios.post('/admin/api/portal/', {form: this.form})
                        .then((response) => {
                            if (response.data) {
                                this.helpers.spinner.save = false;
                                this.helpers.spinner.saveAndReturn = false;
                                window.location.href = '/admin/portal/' + response.data.portal.id + '/edit';
                            }
                        });
                }
            },

            goBack() {
                window.location.href = '/admin/portal';
            }
        },

        computed: {
            dateToday() {
                var date = new Date();
                return date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear();
            }
        },

        watch: {
            'form.languages': function (languages) {
                var me = this;

                // loop langs selected and check if we have staticpages including that lang, if not add them
                languages.forEach((language, index) => {
                    if (!_.map(this.form.staticPages, 'lang_code').includes(language.value)) {

                        // add static pages for each static page type
                        this.staticPageTypes.forEach((staticPageType) => {
                            var staticPage = {
                                id: 0,
                                lang_code: language.value,
                                type: staticPageType,
                                title: '',
                                body: '',
                                visible: false,
                                created_at: this.dateToday,
                                showModal: false
                            }

                            this.form.staticPages.push(staticPage);
                        });
                    }
                });

                // if language removed, remove static pages also
                _.forEachRight(this.form.staticPages, function (staticPage, key) {
                    if (!_.map(me.form.languages, 'value').includes(staticPage.lang_code)) {
                        me.form.staticPages.splice(key, 1);
                        $('[href="#s_page0"]').click();
                    }
                });

                // if language removed, remove dynamic pages also
                _.forEachRight(this.form.pages, function (page, key) {
                    if (!_.map(me.form.languages, 'value').includes(page.lang_code)) {
                        me.form.pages.splice(key, 1);
                        //me.resetPagePositions();
                        $('[href="#d_page0"]').click();
                    }
                });
            }
        }
    }
</script>
