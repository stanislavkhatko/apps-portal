<template>

    <div class="col-xs-12 app-content portal_form" v-if="contentType">
        <div class="panel panel-default">

            <div class="panel-heading">
                <div v-if="contentType_">
                    Edit content type
                </div>
                <div v-else>
                    Create new content type
                </div>
            </div>
            <!-- panel heading -->

            <div class="panel-body">
                <div class="form-horizontal margin_top_20">

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Content type name</label>

                        <div class="col-sm-10">
                            <input type="text" autocomplete="off" class="form-control"
                                   placeholder="Type a name for the content type (will only be used for easy recognition in backend)"
                                   v-model="contentType.name">
                        </div>
                    </div>
                    <!-- portal name section -->

                    <div class="form-group" v-if="contentType_">
                        <label class="col-sm-2 control-label">Content type icon<br/>(Resized to 40x40)</label>
                        <div class="col-sm-10">

                            <template v-if="contentType.icon">

                                <img :src="contentType.icon" class="margin_right_20"/>

                                <button class="btn btn-danger min_width_100" @click="contentType.icon = ''">
                                    Remove icon
                                </button>

                            </template>

                            <template v-else>
                                <dropzone
                                        id="myVueDropzone"
                                        :url="uploadContentTypeIconUrl"
                                        :useFontAwesome="true"
                                        :max-number-of-files=1
                                        :thumbnailWidth=50
                                        :thumbnailHeight=50
                                        v-on:vdropzone-success="uploadContentTypeIcon">
                                    <input type="hidden" name="_token" :value="token">
                                </dropzone>
                            </template>

                        </div>
                    </div>
                    <!-- form-group -->

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Choose languages</label>

                        <div class="col-sm-10 v_select">
                            <v-select
                                    multiple
                                    placeholder="Select content type languages"
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

                            <label class="col-sm-2 control-label">Content type label</label>

                            <div class="col-sm-10">

                                <ul class="nav nav-tabs">
                                    <li v-for="(language, langIdx) in selectedLanguages"
                                        :class="langIdx === 0 ? 'active' : ''">
                                        <a data-toggle="tab" :href="'#s_page' + langIdx">
                                            {{ language.label }}
                                        </a>
                                    </li>
                                </ul>
                                <!-- nav-tabs headers -->

                                <div class="tab-content">
                                    <div :id="'s_page' + langIdx" class="tab-pane"
                                         v-for="(language, langIdx) in selectedLanguages"
                                         :class="langIdx === 0 ? 'in active' : ''">
                                        <input type="text" autocomplete="off" class="form-control"
                                               v-model="contentType.label[language.value]"
                                               :placeholder="language.label + ' label for the content type (e.g. Android games, wallpapers, trailers...)'">
                                    </div>
                                </div>
                                <!-- end tab-content -->

                            </div>
                        </div>
                        <!-- form-group -->

                        <div class="row">
                            <div class="col-sm-offset-2 col-sm-10">
                                <hr/>
                            </div>
                        </div>
                        <!-- hr -->

                        <!-- pages modals -->
                        <modal title="Add existing categories from providers" :backdrop=false
                               :value="searchCategories.showModal" @cancel="searchCategories.showModal = false">
                            <div slot="modal-body" class="modal-body">

                                <div class="form-group">
                                    <label class="col-sm-2 control-label padding_right2_0" style="position: relative">
                                        <span>Providers</span>
                                    </label>
                                    <div class="col-sm-10">
                                        <v-select
                                                v-model="providers.selected"
                                                :options="providers.options"
                                                placeholder="Select a provider">
                                        </v-select>
                                    </div>
                                </div>
                                <!-- form-group -->

                                <div class="form-group" v-if="providers.selected">
                                    <label class="col-sm-2 control-label padding_right2_0" style="position: relative">
                                        <span>Content Type</span>
                                    </label>
                                    <div class="col-sm-10">
                                        <v-select
                                                multiple
                                                :debounce="250"
                                                :on-search="getContentTypes"
                                                :options="searchContentTypes.options"
                                                :on-change="addContentTypeCategoriesToLocalCategories"
                                                placeholder="Search and select a content type to add categories (optional)"
                                                label="label">
                                        </v-select>
                                    </div>
                                </div>
                                <!-- form-group -->

                                <div class="row" v-if="providers.selected">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <hr/>
                                    </div>
                                </div>
                                <!-- hr -->

                                <div class="form-group" v-if="providers.selected">
                                    <label class="col-sm-2 control-label padding_right2_0" style="position: relative">
                                        <span>Categories</span>
                                    </label>
                                    <div class="col-sm-10">
                                        <v-select
                                                multiple
                                                :debounce="250"
                                                :on-search="getCategories"
                                                :options="searchCategories.options"
                                                v-model="searchCategories.selected"
                                                placeholder="Search/select categories"
                                                label="label">
                                        </v-select>
                                    </div>
                                </div>
                                <!-- form-group -->
                            </div>
                            <div slot="modal-footer" class="modal-footer">
                                <button type="button" class="btn btn-default min_width_100 pull-left"
                                        @click="searchCategories.showModal = false">Cancel
                                </button>
                                <button type="button" class="btn btn-success min_width_100"
                                        :class="searchCategories.selected.length > 0 ? '' : 'disabled'"
                                        @click="addSelectedCategories">Add categories
                                </button>
                            </div>
                        </modal>
                        <!-- end pages modals -->


                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                Categories
                            </label>
                            <div class="col-sm-10">


                                <div :class="contentType.local_categories.length > 0 ? 'add_bttn_absolute padding_right_0' : ''">
                                    <button class="btn btn-primary with_cursor"
                                            @click="searchCategories.showModal = true;">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                                <!-- new category button -->

                                <ul class="nav nav-tabs" v-if="contentType.local_categories.length > 0">
                                    <li v-for="(language, langIdx) in selectedLanguages"
                                        :class="langIdx == 0 ? 'active' : ''">
                                        <a data-toggle="tab" :href="'#s_2page' + langIdx">
                                            {{ language.label }}
                                        </a>
                                    </li>
                                </ul>
                                <!-- nav-tabs headers -->

                                <div class="tab-content" v-if="contentType.local_categories.length > 0">
                                    <div :id="'s_2page' + langIdx" class="tab-pane"
                                         v-for="(language, langIdx) in selectedLanguages"
                                         :class="langIdx == 0 ? 'in active' : ''">

                                        <table class="table table-borderless m-b-none"
                                               v-if="contentType.local_categories.length > 0">
                                            <thead>
                                            <tr>
                                                <th>Label ({{ language.label }})</th>
                                                <th style="width: 77px;">Adult</th>
                                                <th style="width: 110px;">
                                                    Edit Content<br/>items
                                                    <tooltip
                                                            content="Content items to be shown<br />/<br />Conten items available from provider"
                                                            style="position: relative;">
                                                        <i class="fa fa-question-circle"></i>
                                                    </tooltip>
                                                </th>
                                                <th style="width: 124px;">
                                                    Auto sync<br/>content items
                                                    <tooltip
                                                            content="Choose if new content items are automatically added to the category if a provider adds new items for the linked category"
                                                            style="position: relative;">
                                                        <i class="fa fa-question-circle"></i>
                                                    </tooltip>
                                                </th>
                                                <th style="width: 280px;">Provider info</th>
                                                <th style='width:50px;'></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <template v-for="(category, idx) in contentType.local_categories">
                                                <tr>
                                                    <td>
                                                        <input
                                                                type="text"
                                                                autocomplete="off"
                                                                class="form-control"
                                                                v-model="category.label[language.value]"
                                                                :placeholder="language.label + ' label for the category...'">
                                                    </td>
                                                    <td>
                                                        <v-select2
                                                                v-model="category.adult"
                                                                :options="helpers.adult">
                                                        </v-select2>
                                                    </td>
                                                    <td>

                                                        <div class="btn btn-default"
                                                             @click="showContentItemsModal(category)"
                                                             v-if="category.id != 0">
                                                            <i class="fa fa-pencil"></i>&nbsp;&nbsp;<strong>{{
                                                            category.content_items_count }}
                                                            <small>/{{ category.provider_content_items_count }}</small>
                                                        </strong>
                                                        </div>

                                                        <tooltip v-if="category.id == 0"
                                                                 content="Save content type first to manage content items"
                                                                 style="position: relative;">
                                                            <button class="btn btn-default" style="opacity: 0.5;">
                                                                <i class="fa fa-question-circle"></i>&nbsp;&nbsp;<strong>{{
                                                                category.content_items_count }}
                                                                <small>/{{ category.provider_content_items_count }}
                                                                </small>
                                                            </strong>
                                                            </button>
                                                        </tooltip>
                                                    </td>
                                                    <td>
                                                        <v-select2
                                                                v-model="category.auto_sync_content_items"
                                                                :options="helpers.sync">
                                                        </v-select2>
                                                    </td>
                                                    <td>
                                                        Provider: <strong>{{ category.content_type.provider }}</strong>
                                                        <br>
                                                        Content Type: <strong>{{ category.content_type.label }}</strong>
                                                        <br>
                                                        Category: <strong>{{ category.provider_category_label
                                                        }}</strong>
                                                        <br>
                                                        Adult: <strong>{{ category.provider_category_adult == 1 ? 'Yes':
                                                        'No' }}</strong>
                                                        <br>
                                                        Content items available: <strong>{{
                                                        category.provider_content_items_count }}</strong>
                                                    </td>
                                                    <td class="text-right padding_right_0">
                                                        <div class="btn btn-danger"
                                                             @click="removeCategoryFromContentType(idx)">
                                                            <i class="fa fa-times"></i>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </template>
                                            </tbody>
                                        </table>

                                    </div>
                                    <!-- end tab-pane -->
                                </div>
                                <!-- end tab-content -->

                                <content-items-manager
                                        @emitUpdateContentItemsCount="updateContentItemsCount"
                                        :contentItemsManager="helpers.contentItemsManager">
                                </content-items-manager>

                                <div v-if="contentType.local_categories.length > 0">
                                    <i>Total categories: <strong>{{ contentType.local_categories.length }}</strong></i>
                                    &nbsp;&nbsp;&nbsp;<i>|</i>&nbsp;&nbsp;
                                    <i>Total contentItems: <strong>{{ allContentItemsLength }}</strong></i>
                                </div>
                            </div>
                        </div>
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
    import {modal, select, tooltip} from 'vue-strap';
    import _ from 'lodash';
    import ContentItemsManager from './ContentItemsManager.vue'
    import Dropzone from 'vue2-dropzone';

    export default {

        components: {
            modal, tooltip, vSelect2: select, ContentItemsManager, Dropzone
        },

        props: {
            languages: {},
            contentType_: {}
        },

        data() {
            return {

                token: Laravel.csrfToken,

                selectedLanguages: [],

                providers: {
                    selected: '',
                    options: ['Melodimedia', 'System', 'Mobibase']
                },

                searchContentTypes: {
                    options: [],
                    selected: []
                },

                searchCategories: {
                    options: [],
                    selected: [],
                    showModal: false
                },

                // searchContentItems: {
                //     options: [],
                //     selected: '',
                //     showModal: false
                // },

                helpers: {
                    contentItemsManager: {
                        showModal: false,
                        category: {}
                    },

                    spinner: {
                        save: false,
                        saveAndReturn: false
                    },

                    adult: [
                        {value: 0, label: 'No'},
                        {value: 1, label: 'Yes'}
                    ],

                    sync: [
                        {value: 0, label: 'No'},
                        {value: 1, label: 'Yes'}
                    ]
                },

                contentType: {
                    id: 0,
                    remote_id: 0,
                    provider: 'local',
                    name: '',
                    label: {},
                    local_categories: [],
                }
            }
        },

        mounted() {
            if (this.contentType_) {
                this.contentType = this.contentType_;

                this.languages.forEach((language) => {
                    if (this.contentType.label[language.value]) {
                        this.selectedLanguages.push(language);
                    }
                });
            }
        },

        computed: {

            dateToday() {
                var date = new Date();
                return date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear();
            },

            allContentItemsLength() {
                var me = this;
                var count = 0;

                _.forEach(me.contentType.local_categories, function (category) {
                    count += category.content_items_count;
                });

                return count;
            },
            uploadContentTypeIconUrl() {
                return '/admin/api/local-content-type/' + this.contentType_.id + '/upload-icon'
            },
        },

        methods: {

            updateContentItemsCount: function (params) {

                this.contentType.local_categories.forEach((category) => {
                    if (category.id == params.category_id) {
                        category.content_items_count = params.content_items_count;
                    }
                });
            },

            showContentItemsModal(category) {
                this.helpers.contentItemsManager.category = category;
                this.helpers.contentItemsManager.showModal = true;
            },

            addContentTypeCategoriesToLocalCategories(contentTypes) {
                contentTypes.forEach((contentType) => {
                    contentType.categories.forEach((category) => {
                        this.searchCategories.selected.push(category);
                    });
                });
            },

            addSelectedCategories() {
                // vselect
                if (this.searchCategories.selected) {

                    // fill category
                    this.searchCategories.selected.forEach((category) => {

                        var local_category = {
                            id: 0,
                            provider_category_id: category.id,
                            content_type_id: 0,
                            content_type: category.content_type,
                            provider_category_label: category.label,
                            provider_content_items_count: category.content_items_count,
                            label: {},
                            adult: category.adult,
                            content_items_count: category.content_items_count,
                            auto_sync_content_items: 1,
                            created_at: this.dateToday
                        };

                        // fill label with keys of selected languages
                        this.selectedLanguages.forEach((language) => {
                            this.$set(local_category.label, language.value, category.label);
                        });

                        this.contentType.local_categories.push(local_category);
                    });

                    // reset
                    this.providers.selected = '',
                        this.searchContentTypes.selected = [];
                    this.searchContentTypes.options = [];
                    this.searchCategories.selected = [];
                    this.searchCategories.options = [];
                }

                this.searchCategories.showModal = false;
            },

            getContentTypes(search, loading) {
                loading(true);
                // retrieve searched items
                axios.get('/admin/api/local-content-type/provider/' + this.providers.selected + '/' + search)
                    .then(resp => {
                        this.searchContentTypes.options = resp.data;
                        //this.removeExistingCategoriesFromSearch(this.searchCategories.options);
                        loading(false)
                    });
            },

            getCategories(search, loading) {
                loading(true);
                // retrieve searched items
                axios.get('/admin/api/local-content-type/categories/provider/' + this.providers.selected + '/' + search)
                    .then(resp => {
                        this.searchCategories.options = resp.data;
                        this.removeExistingCategoriesFromSearch(this.searchCategories.options);
                        loading(false)
                    });
            },

            // loop through the returned searched content items and check if we already have contentitems included for our category, if so, remove them from search
            removeExistingCategoriesFromSearch(searchCategories) {
                var me = this;
                _.forEachRight(searchCategories, function (category, index) {
                    if (_.map(me.contentType.local_categories, 'id').includes(category.id)) {
                        searchCategories.splice(index, 1);
                    }
                });
            },

            removeCategoryFromContentType(idx) {
                this.contentType.local_categories.splice(idx, 1);
            },

            uploadContentTypeIcon(file, response) {
                this.contentType.icon = response;
            },

            save(goBack) {

                goBack ? this.helpers.spinner.saveAndReturn = true : this.helpers.spinner.save = true;

                // update
                if (this.contentType_) {
                    axios.patch('/admin/api/local-content-type/' + this.contentType.id, this.contentType)
                        .then((response) => {
                            if (response.data) {
                                this.helpers.spinner.save = false;
                                this.helpers.spinner.saveAndReturn = false;
                                if (goBack) this.goBack();
                                else location.reload();
                            }
                        });
                } else {
                    axios.post('/admin/api/local-content-type/', this.contentType)
                        .then((response) => {
                            if (response.data) {
                                console.log(response.data);
                                this.helpers.spinner.save = false;
                                this.helpers.spinner.saveAndReturn = false;
                                window.location.href = '/admin/local-content-types/' + response.data.id + '/edit';
                            }
                        });
                }
            },

            goBack() {
                window.location.href = '/admin/local-content-types';
            },
        },
        watch: {
            'selectedLanguages': function (languages) {
                var me = this;

                // loop selected languages and add it to labels if not allready exists (hasownproperty...)
                languages.forEach((language) => {
                    if (!me.contentType.label.hasOwnProperty(language.value)) {

                        me.$set(me.contentType.label, language.value);

                        me.contentType.local_categories.forEach((category) => {
                            me.$set(category.label, language.value, category.provider_category_label);
                        });
                    }
                });

                // check all languages from label, if lang not selected anymore, delete
                _.forEachRight(this.contentType.label, function (label, key) {
                    if (!_.map(me.selectedLanguages, 'value').includes(key)) {
                        me.$delete(me.contentType.label, key);
                        $('[href="#s_page0"]').click();

                        me.contentType.local_categories.forEach((category) => {
                            me.$delete(category.label, key);
                            $('[href="#s_2page0"]').click();
                        });
                    }
                });

            }
        }
    }
</script>
