<template>

    <div class="col-xs-12 app-content portal_form">
        <div class="panel panel-default">

            <div class="panel-heading">
                <div>
                    <span v-if="item">Edit content item</span>
                    <span v-else>Create a new content item</span>
                </div>
            </div>
            <!-- panel heading -->
            {{ item }}


            <div class="panel-body">
                <div class="form-horizontal margin_top_20">

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Provider</label>
                        <div class="col-sm-4">
                            <input type="text" autocomplete="off" class="form-control" v-model="contentItem.provider"
                                   disabled>
                        </div>
                        <template v-if="contentItem.created_at">
                            <label class="col-sm-1 control-label">Created</label>
                            <div class="col-sm-2">
                                <input type="text" autocomplete="off" class="form-control"
                                       v-model="contentItem.created_at" disabled>
                            </div>
                            <label class="col-sm-1 control-label">Updated</label>
                            <div class="col-sm-2">
                                <input type="text" autocomplete="off" class="form-control"
                                       v-model="contentItem.updated_at" disabled>
                            </div>
                        </template>
                    </div>

                    <div class="row">
                        <div class="col-sm-offset-2 col-sm-10">
                            <hr/>
                        </div>
                    </div>
                    <!-- hr -->

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Content type</label>
                        <div class="col-sm-10">
                            <v-select
                                    placeholder="Select content types"
                                    v-model="contentType"
                                    :options="contentTypes"
                                    :on-change="changedContentType">
                            </v-select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Category</label>
                        <div class="col-sm-10">

                            <template v-if="categories.length > 0">
                                <v-select
                                        :options="categories"
                                        v-model="category"
                                        placeholder="Search or select a category"
                                        :on-change="changedCategory"
                                >
                                </v-select>
                            </template>

                            <template v-else>
                                <input v-if="!contentType" type="text" class="form-control"
                                       value="Select a content type to see categories" disabled>
                                <input v-if="contentType" type="text" class="form-control"
                                       value="No categories available, create a new category first." disabled>
                            </template>

                        </div>
                    </div>


                    <div class="form-group" v-if="contentItem.compatibility">
                        <label class="col-sm-2 control-label">Device</label>
                        <div class="col-sm-10">

                            <v-select
                                    v-model="helpers.devices.selected"
                                    :on-change="changedDevice"
                                    :options="helpers.devices.options"
                                    placeholder="Select a device">
                            </v-select>

                        </div>
                    </div>

                    <div class="form-group"
                         v-if="contentItem.compatibility && contentItem.compatibility.os === 'Android'">
                        <label class="col-sm-2 control-label">Min. Version</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="Type a min. version e.g. 4.0.1"
                                   v-model="contentItem.compatibility.minVersion"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Rating</label>
                        <div class="col-sm-10">
                            <star-rating :star-size="20" v-model="contentItem.rating"></star-rating>
                        </div>
                    </div>

                    <template v-if="contentTypeId && contentItem.category_id">

                        <div class="row">
                            <div class="col-sm-offset-2 col-sm-10">
                                <hr/>
                            </div>
                        </div>
                        <!-- hr -->

                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                Item content
                            </label>

                            <div class="col-sm-10">

                                <div href="#" class="btn btn-primary" :class="contentItemHasContent ? 'pull-right' : ''"
                                     @click="helpers.showNewLanguageModal = true">
                                    <i class="fa fa-plus"></i>
                                </div>

                                <modal title="Select a new language" :value="helpers.showNewLanguageModal"
                                       @cancel="helpers.showNewLanguageModal = false" :backdrop=false>
                                    <div slot="modal-body" class="modal-body">

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">
                                                Langauges
                                            </label>
                                            <div class="col-sm-10 v_select">
                                                <v-select
                                                        placeholder="Select a new language"
                                                        v-model="newSelectedLanguage"
                                                        :options="newLanguagesOnly">
                                                </v-select>
                                            </div>
                                        </div>
                                        <!-- form-group -->

                                    </div>
                                    <div slot="modal-footer" class="modal-footer">
                                        <button type="button" class="btn btn-default min_width_100 pull-left"
                                                @click="helpers.showNewLanguageModal = false">Cancel
                                        </button>
                                        <button
                                                type="button"
                                                class="btn btn-success min_width_100"
                                                :class="newSelectedLanguage ? '' : 'disabled'"
                                                @click="addLanguage()">
                                            Add language
                                        </button>
                                    </div>
                                </modal>

                                <ul class="nav nav-tabs width_100_minus_bttn">
                                    <li v-for="(appPerLanguage, key, idx) in contentItem.title"
                                        :class="idx == helpers.activeTab ? 'active' : ''">
                                        <a data-toggle="tab" :href="'#tab' + idx">{{ key }}</a>
                                    </li>
                                </ul>

                                <div class="tab-content" v-if="contentItemHasContent">
                                    <div class="tab-pane" v-for="(appPerLanguage, key, idx) in contentItem.title"
                                         :id="'tab' + idx" :class="idx == helpers.activeTab ? 'in active' : ''">

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Language</label>
                                            <div class="col-sm-10">
                                                <input type="text" autocomplete="off" class="form-control"
                                                       v-model="findLanguageByCode(key).label"
                                                       v-if="findLanguageByCode(key)" disabled>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Title</label>

                                            <div class="col-sm-10">
                                                <input type="text" autocomplete="off" class="form-control"
                                                       placeholder="Type a title" v-model="contentItem.title[key]">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Content</label>

                                            <div class="col-sm-10">
                                                <froala :config="froalaConfig"
                                                        v-model="contentItem.description[key]"></froala>
                                            </div>
                                        </div>

                                        <div style="clear:both;"></div>

                                        <div class="margin_top_10 pull-right">
                                            <button class="btn btn-danger min_width_100" @click="removeLanguage(key)">
                                                Remove <span v-if="findLanguageByCode(key)">{{ findLanguageByCode(key).label }}</span>
                                                language
                                            </button>
                                        </div>

                                        <div style="clear:both;"></div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- content item text section -->


                        <div class="row">
                            <div class="col-sm-offset-2 col-sm-10">
                                <hr/>
                            </div>
                        </div>
                        <!-- hr -->


                        <div class="form-group" v-if="item">
                            <label class="col-sm-2 control-label">Item preview image<br/>(290x290)</label>
                            <div class="col-sm-10">

                                <template v-if="contentItem.preview">

                                    <img :src="contentItem.preview"/>

                                    <div class="margin_top_10">
                                        <button class="btn btn-danger min_width_100" @click="contentItem.preview = ''">
                                            Remove preview image
                                        </button>
                                    </div>
                                </template>

                                <template v-else>
                                    <dropzone
                                            id="myVueDropzone"
                                            :url="'/admin/api/content-item/' + contentItem.id + '/upload-image'"
                                            :useFontAwesome="true"
                                            :max-number-of-files=1
                                            :thumbnailWidth=240
                                            v-on:vdropzone-success="uploadContentItemImage">
                                        <input type="hidden" name="_token" :value="token">
                                    </dropzone>
                                </template>

                            </div>
                        </div>
                        <!-- form-group -->


                        <template v-if="item">

                            <div class="row">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <hr/>
                                </div>
                            </div>
                            <!-- hr -->

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Download type</label>
                                <div class="col-sm-10">
                                    <v-select v-model="contentItem.type" :options="helpers.download.options"
                                              placeholder="Select a download type"></v-select>
                                </div>
                            </div>
                            <!-- form-group -->


                            <div class="form-group" v-if="contentItem.type === 'reference'">
                                <label class="col-sm-2 control-label">Download link</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" v-model="contentItem.download.link"
                                           placeholder="Type a link/location where file/game can be found"/>
                                </div>
                            </div>
                            <!-- form-group -->

                            <div class="form-group" v-else>
                                <label class="col-sm-2 control-label">File (e.g. APK, image, video)</label>
                                <div class="col-sm-10">

                                    <template v-if="contentItem.download.link">

                                        <a :href="'/download/'+contentItem.id" class="file_download_link"
                                           target="_blank">
                                            Click here to download file
                                            <mark>{{ contentItem.download.link }}</mark>
                                        </a>
                                        <button class="btn btn-danger min_width_100"
                                                @click="contentItem.download.link = ''">
                                            Remove file
                                        </button>

                                    </template>

                                    <template v-else>
                                        <dropzone
                                                id="myVueDropzone2"
                                                :url="'/admin/api/content-item/' + contentItem.id + '/upload-file'"
                                                :useFontAwesome="true"
                                                :max-number-of-files=1
                                                :thumbnailHeight=240
                                                :thumbnailWidth=240
                                                :maxFileSizeInMB=100
                                                :timeout=250000
                                                v-on:vdropzone-success="uploadContentItemFile">
                                            <input type="hidden" name="_token" :value="token">
                                        </dropzone>
                                    </template>

                                </div>
                            </div>
                            <!-- form-group -->
                        </template>

                    </template>

                    <div class="form-group margin_top_40">
                        <div class="col-sm-offset-2 col-sm-10 text-right">

                            <button class="btn btn-success min_width_100"
                                    @click="saveContentItem(true)"
                                    :class="helpers.spinner.saveAndReturn || helpers.spinner.save ? 'disabled' : ''">
                                <span v-show="!helpers.spinner.saveAndReturn">Save & return</span>
                                <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw bttn_spinner"
                                   v-show="helpers.spinner.saveAndReturn"></i>
                            </button>

                            <button class="btn btn-success min_width_100"
                                    @click="saveContentItem()"
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
    import {modal, select} from 'vue-strap';
    import _ from 'lodash';
    import Dropzone from 'vue2-dropzone';
    import StarRating from 'vue-star-rating'

    export default {

        components: {
            modal, Dropzone, StarRating, vSelect2: select
        },

        props: {
            languages: {},
            item: {},
            contentTypes: {},
        },

        data() {
            return {

                token: Laravel.csrfToken,

                froalaConfig: {
                    toolbarButtons: ['fullscreen', '|', 'bold', 'italic', 'strikeThrough', 'underline', '|', 'paragraphFormat', 'paragraphStyle', 'align', 'formatOL', 'formatUL', 'indent', 'outdent', '|', 'insertLink', 'insertVideo', 'insertFile', 'html'],
                    pluginsEnabled: ['fullscreen', 'align', 'link', 'table', 'paragraphFormat', 'paragraphStyle', 'quote', 'lists', 'fontFamily'],
                    heightMin: 300
                },

                helpers: {
                    activeTab: 0,
                    spinner: {
                        save: false,
                        saveAndReturn: false
                    },
                    devices: {
                        selected: '',
                        options: [
                            {label: 'All (e.g. browser game)', value: 'All'},
                            {label: 'Android', value: 'Android'}
                        ]
                    },
                    showNewLanguageModal: false,
                    download: {
                        options: ['reference', 'upload']
                    }
                },

                contentItem: {
                    type: 'upload',
                    provider: 'system',
                    remote_id: 0,
                    category_id: '',
                    title: {},
                    description: {},
                    preview: '',
                    compatibility: {
                        minVersion: "",
                        os: ""
                    },
                    download: {
                        link: ''
                    }
                },

                contentTypeId: '',
                categories: [],
                newSelectedLanguage: '',
            }
        },

        mounted() {
            if (this.item) {
                this.contentItem = this.item;
                this.contentTypeId = this.item.category.content_type_id;
                this.provider = this.contentType.provider;

                // set active tab to english
                if (this.contentItemHasContent) {
                    this.helpers.activeTab = this.contentItemLanguages.indexOf('en');
                }

                // compatibility
                if (this.contentItem.compatibility.os === 'Android') {
                    this.helpers.devices.selected = this.helpers.devices.options[1];
                }
                else {
                    this.helpers.devices.selected = this.helpers.devices.options[0];
                }
            }
        },

        computed: {

            contentItemLanguages() {
                return Object.keys(this.contentItem.title);
            },

            contentItemHasContent() {
                if (this.contentItemLanguages.length > 0) {
                    return true;
                }
                return false;
            },

            contentType() {
                return _.find(this.contentTypes, (contentType) => contentType.value === this.contentTypeId);
            },

            category() {
                return _.find(this.categories, (category) => category.id === this.contentItem.category_id);
            },

            // only show languages which are not being used allready
            newLanguagesOnly() {
                if (this.contentItemLanguages) {
                    var lang = [];

                    this.languages.forEach((language, index) => {
                        if (this.contentItemLanguages.includes(language.value) == false) {
                            lang.push(language);
                        }
                    });

                    return lang;
                }
                else {
                    return this.languages;
                }
            }
        },

        methods: {

            addLanguage() {

                this.$set(this.contentItem.title, this.newSelectedLanguage.value, '');
                // this.contentItem.title = Object.assign({}, {en: ''});

                this.$set(this.contentItem.description, this.newSelectedLanguage.value, '');
                // this.contentItem.description = Object.assign({}, {en: ''});

                this.newSelectedLanguage = '';
                this.helpers.activeTab = this.contentItemLanguages.length - 1;
                this.helpers.showNewLanguageModal = false;
            },

            removeLanguage(key) {
                this.$delete(this.contentItem.title, key);
                this.$delete(this.contentItem.description, key);

                if (this.contentItemHasContent) {
                    //this.helpers.activeTab = this.contentItemLanguages.length - 1;
                    this.helpers.activeTab = null;
                }
            },

            findLanguageByCode(code) {
                return _.find(this.languages, (lang) => lang.value === code);
            },

            // getCategories(search, loading) {
            //     loading(true);
            //     // retrieve searched items
            //     axios.get('/admin/api/content-item/categories/' + search)
            //         .then(resp => {
            //             this.categories = resp.data
            //             loading(false)
            //         });
            // },

            getCategories() {

                axios.get('/admin/api/content-item/content-type/' + this.contentTypeId + '/categories/')
                    .then(resp => {
                        this.categories = resp.data;
                    });
            },

            changedContentType(contentType) {
                this.contentTypeId = contentType.value;
                this.getCategories();
            },

            changedCategory(category) {
                this.contentItem.category_id = category.id;
            },

            changedDevice(device) {
                if (device.value === 'Android') {
                    this.contentItem.compatibility.os = 'Android';
                }
                else {
                    this.contentItem.compatibility.os = '';
                }
            },

            // changedDownloadType(type) {
            //     this.contentItem.download.type = type.value;
            // },

            uploadContentItemImage(file, response) {
                this.contentItem.preview = response;
            },

            uploadContentItemFile(file, response) {
                this.contentItem.download.link = response;
            },

            updateTheme(goBack) {

            },

            saveContentItem(goBack) {
                if (goBack) {
                    this.helpers.spinner.saveAndReturn = true;
                }
                else {
                    this.helpers.spinner.save = true;
                }

                this.contentItem.is_customized = true;

                // update
                if (this.item) {
                    axios.patch('/admin/api/content-item/' + this.contentItem.id, this.contentItem)
                        .then((response) => {
                            if (response.data) {
                                this.helpers.spinner.save = false;
                                this.helpers.spinner.saveAndReturn = false;
                                if (goBack) this.goBack();
                                location.reload();
                            }
                        });
                } else {
                    axios.post('/admin/api/content-item/', this.contentItem)
                        .then((response) => {
                            if (response.data) {
                                this.helpers.spinner.save = false;
                                this.helpers.spinner.saveAndReturn = false;
                                window.location.href = '/admin/content-items/' + response.data.id + '/edit';
                            }
                        });
                }
            },

            goBack() {
                window.location.href = '/admin/content-items';
            }
        }
    }
</script>
