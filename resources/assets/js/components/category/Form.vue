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
                                    placeholder="Select a content type this category belongs to"
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

                    <div class="form-group margin_top_40">
                        <div class="col-sm-offset-2 col-sm-10 text-right">    
                            
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
        contentTypes: {},
        category_: {}
    },

    data() {
        return {

            category: {
                id: 0,
                remote_id: 0,
                adult: 0,
                content_type_id: '',
                label: ''
            },

            helpers: {
                adult: [
                    {value: 0, label: 'No'},
                    {value: 1, label: 'Yes'}
                ],
                spinner: {
                    save: false,
                    saveAndReturn: false
                }
            }         
        }
    },

    mounted() {
        if (this.category_) this.category = this.category_;
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

        save(goBack) {

            goBack ? this.helpers.spinner.saveAndReturn = true : this.helpers.spinner.save = true;

            // update
            if (this.category_) {
                axios.patch('/admin/api/category/' + this.category.id , {category: this.category})
                    .then((response) => {
                        if (response.data) {
                            this.helpers.spinner.save = false;
                            this.helpers.spinner.saveAndReturn = false;                            
                            if (goBack) window.location.href = '/admin/categories';
                        }
                    });
            }

            // new
            else {
                axios.post('/admin/api/category/', {category: this.category})
                    .then((response) => {
                        if (response.data) {
                            this.helpers.spinner.save = false;
                            this.helpers.spinner.saveAndReturn = false;
                            window.location.href = '/admin/categories/' + response.data.category.id + '/edit';
                        }
                    });
            }            
        }
    }
}
</script>
