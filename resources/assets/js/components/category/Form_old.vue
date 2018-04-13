<template>
	
    <div class="col-xs-12 app-content portal_form" v-if="category">
        <div class="panel panel-default">

            <div class="panel-heading">
                <div v-if="category_">
                    Edit category
                </div>
                <div v-else>
                    Create new category
                </div>
            </div>
            <!-- panel heading -->

            <div class="panel-body">
                <div class="form-horizontal margin_top_20">

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Content type</label>
                        <div class="col-sm-10">
                            <v-select
                                    placeholder="Select content types (optional)"
                                    v-model="contentType"
                                    :options="contentTypes"
                                    :on-change="changedContentType">
                            </v-select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Category</label>
                        <div class="col-sm-10">
                            <input type="text" autocomplete="off" class="form-control" v-model="category.label" placeholder="Type a name for the category (e.g. Sports, puzzles, security...) ">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Adult content</label>
                        <div class="col-sm-10">  

                            <v-select2
                                v-model="category.adult" 
                                :options="helpers.adult" 
                                class="width_100_percent"
                                placeholder="Does this category contains adult content?">    
                            </v-select2>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-offset-2 col-sm-10">
                            <hr />
                        </div>
                    </div>
                    <!-- hr -->

                    <!-- pages modals --> 
                    <modal title="Content items" :backdrop=false :value="searchContentItems.showModal" @cancel="searchContentItems.showModal = false">
                        <div slot="modal-body" class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Add content items</label>
                                <div class="col-sm-10">
                                    <v-select
                                        multiple
                                        :debounce="250"
                                        :on-search="getContentItems"
                                        :options="searchContentItems.options"
                                        v-model="searchContentItems.selected"
                                        placeholder="Search content items"
                                        label="titleTranslated">
                                    </v-select>
                                </div>
                            </div>
                            <!-- form-group -->
                        </div>
                        <div slot="modal-footer" class="modal-footer">
                            <button type="button" class="btn btn-default min_width_100 pull-left" @click="searchContentItems.showModal = false">Cancel</button>
                            <button type="button" class="btn btn-success min_width_100" :class="searchContentItems.selected ? '' : 'disabled'" @click="addSelectedContentItems">Add selected items</button>
                        </div>
                    </modal>
                    <!-- end pages modals --> 


                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Content items
                            <div @click="showIconAndDescrMethod" class="custom_link" v-if="category.content_items.length > 0">
                                <span v-if="helpers.showIconAndDescr">(Hide icons and descriptions)</span>
                                <span v-if="!helpers.showIconAndDescr">(Show icons and descriptions)</span>
                            </div>
                        </label>
                        <div class="col-sm-10">

                                    <div :class="category.content_items.length > 0 ? 'add_bttn_absolute padding_right_0' : ''">
                                        <button class="btn btn-primary with_cursor" @click="searchContentItems.showModal = true;">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                    <!-- new button -->

                            <table class="table table-borderless m-b-none" v-if="category.content_items.length > 0">
                                <thead>
                                    <tr>
                                        <th style="width: 85px;" v-if="helpers.showIconAndDescr">Icon</th>
                                        <th>Info</th>
                                        <th>provider</th>
                                        <th style='width:120px;'>Created</th>
                                        <th style='width:100px;'></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="(content_item, idx) in category.content_items">
                                        <tr>
                                            <td v-if="helpers.showIconAndDescr">
                                                <img :src="content_item.preview" class="img-responsive">
                                            </td>
                                            <td>
                                                <strong>{{ content_item.title['en'] }}</strong>
                                                <div class="description" v-if="content_item.description['en'] && helpers.showIconAndDescr">
                                                    {{ content_item.description['en'].substring(0, 180) }}...
                                                </div>                                                
                                            </td>   
                                            <td>
                                                {{ content_item.provider }}
                                            </td>                                         
                                            <td>{{ content_item.created_at }}</td>
                                            <td class="text-right padding_right_0">
                                                <a class="btn btn-default" target="_blank" :href="'/admin/content-items/' + content_item.id +'/edit'"> 
                                                    <i class="fa fa-pencil"></i>
                                                </a> 
                                                <div class="btn btn-danger" @click="removeContentItemFromCategory(idx)"> 
                                                    <i class="fa fa-times"></i>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                            <div v-if="category.content_items.length > 0">
                                <i>Total content items: {{ category.content_items.length }}</i>
                            </div>
                        </div>
                    </div>

                 
                    <div class="form-group margin_top_40">
                        <div class="col-sm-offset-2 col-sm-10 text-right">
                            
                            <button class="btn btn-default min_width_100 pull-left" @click="cancel">
                                Cancel
                            </button>       
                            
                            <button class="btn btn-success min_width_100" 
                                    @click="save(true)" 
                                    :class="helpers.spinner.saveAndReturn || helpers.spinner.save ? 'disabled' : ''">                                
                                <span v-show="!helpers.spinner.saveAndReturn">Save & return</span>
                                <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw bttn_spinner" v-show="helpers.spinner.saveAndReturn"></i>
                            </button>    

                            <button class="btn btn-success min_width_100"
                                    @click="save()" 
                                    :class="helpers.spinner.saveAndReturn || helpers.spinner.save ? 'disabled' : ''"> 
                                <span v-show="!helpers.spinner.save">Save</span>
                                <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw bttn_spinner" v-show="helpers.spinner.save"></i>
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
import { tabs, tab, tabGroup, tabset, modal, select } from 'vue-strap';
import _ from 'lodash';

export default {
	
	components: {
		tabs, tab, tabGroup, tabset, modal, vSelect2: select
	},

    props: {
        languages: {},
        category_: {},
        contentTypes: {}
    },

    data() {
        return {

            category: {
                adult: '',
                content_type_id: '',
                content_items: [],
                content_type: {
                    label: ''
                },
                label: ''
            },

            searchContentItems: {
                options: [],
                selected: '',
                showModal: false
            },

            helpers: {
                showIconAndDescr: true,
                adult: [
                    {value: 0, label: 'No'},
                    {value: 1, label: 'Yes'}
                ],
                activeTab: 0,
                spinner: {
                    save: false,
                    saveAndReturn: false
                }
            }         
        }
    },

    mounted() {
        if (this.category_) {
            this.category = this.category_;
        }        
        this.helpers.showIconAndDescr = localStorage.getItem('showIconAndDescr') == "false" ? false : true;
    },

    computed: {

        contentType() {
            return _.find(this.contentTypes, (contentType) => contentType.value === this.category.content_type_id);
        },
    },

    methods: {  

        changedContentType(contentType) {
            this.category.content_type_id = contentType.value;
        },

        showIconAndDescrMethod() {
            this.helpers.showIconAndDescr = !this.helpers.showIconAndDescr;
            localStorage.setItem('showIconAndDescr', this.helpers.showIconAndDescr);
        },

        addSelectedContentItems() {            
            this.category.content_items = _.concat(this.searchContentItems.selected, this.category.content_items);
            this.searchContentItems.selected = "";
            this.searchContentItems.options = [];
            this.searchContentItems.showModal = false;
        },

        getContentItems(search, loading) {
            loading(true);
            // retrieve searched items
            axios.get('/admin/api/portal/contentitems/' + search)
                .then(resp => {
                    this.searchContentItems.options = resp.data;
                    this.removeExistingContentItemsFromSearch(this.searchContentItems.options);
                    loading(false)
                });
        },

        // loop through the returned searched content items and check if we already have contentitems included for our category, if so, remove them from search
        removeExistingContentItemsFromSearch(searchContentItems) {
            var me = this;
            _.forEachRight(searchContentItems, function(contentItem, index) {
                if (_.map(me.category.content_items, 'id').includes(contentItem.id)) {                    
                    searchContentItems.splice(index, 1);
                }
            });
        },

        removeContentItemFromCategory(idx) {
            this.category.content_items.splice(idx, 1);
        },

        save(goBack) {

        },

        cancel() {
            window.history.back();
        },
    }
}
</script>
