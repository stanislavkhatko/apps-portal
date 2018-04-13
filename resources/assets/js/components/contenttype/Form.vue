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
                        <label class="col-sm-2 control-label">
                            Provider
                        </label>
                        <div class="col-sm-10">
                            <input type="text" value="System" autocomplete="off" class="form-control" disabled>
                        </div>                        
                    </div>
                    <!-- form-group -->


                    <div class="form-group">
                        <label class="col-sm-2 control-label">Content type name</label>

                        <div class="col-sm-10">
                            <input type="text" autocomplete="off" class="form-control" placeholder="Type a name for the content type" v-model="contentType.label">
                        </div>
                    </div>
                    <!-- portal name section -->
                 
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
import { modal, select, tooltip } from 'vue-strap';
import _ from 'lodash';

export default {
	
	components: {
		modal, tooltip, vSelect2: select
	},

    props: {
        contentType_: {}
    },

    data() {
        return {
            helpers: {
                spinner: {
                    save: false,
                    saveAndReturn: false
                }
            },

            contentType: {
                id: 0,
                label: ''
            }
        }
    },

    mounted() {
        if (this.contentType_) this.contentType = this.contentType_;
    },

    computed: {

    },

    methods: {  

        save(goBack) {

            goBack ? this.helpers.spinner.saveAndReturn = true : this.helpers.spinner.save = true;

            // update
            if (this.contentType_) {
                axios.patch('/admin/api/content-type/' + this.contentType.id , {contentType: this.contentType})
                    .then((response) => {
                        if (response.data) {
                            this.helpers.spinner.save = false;
                            this.helpers.spinner.saveAndReturn = false;                            
                            if (goBack) this.goBack();
                        }
                    });
            }

            // new
            else {
                axios.post('/admin/api/content-type', {contentType: this.contentType})
                    .then((response) => {
                        if (response.data) {
                            this.helpers.spinner.save = false;
                            this.helpers.spinner.saveAndReturn = false;
                            window.location.href = '/admin/content-types/' + response.data.contentType.id + '/edit';
                        }
                    });
            }            
        },

        goBack() {
            window.location.href = '/admin/content-types';
        }
    }
}
</script>
