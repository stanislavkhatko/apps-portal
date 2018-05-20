<template>
	<div> 

		<div :class="form.featuredApps.length > 0 ? 'add_bttn_absolute padding_right_0' : ''">      
            <button class="btn btn-primary with_cursor" @click="featuredModal.edit = false;featuredModal.show = true;">
                <i class="fa fa-plus"></i>
            </button>
        </div>
        <!-- new button -->


        <table class="table table-borderless m-b-none table_pages" v-if="form.featuredApps.length > 0">
            <thead>
                <tr>
                    <th>App</th>   
                    <th style="width:200px;">Banner</th>                  
                    <th style=''>Created</th>
                    <th style=''></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(app, idx) in form.featuredApps" :class="app.visible == 0 ? 'bg-warning' : ''">                                            
                    <td :class="app.visible == 0 ? 'line_through' : ''">
                        {{ app.content_item_title }}
                    </td>
                    <td>
                    	<template v-if="app.banner">
                    		<img :src="app.banner" class="img-responsive" />
                    	</template>
                    	<template v-else>
                    		<i>(No banner)</i>
                    	</template>                        
                    </td>
                    <td :class="app.visible == 0 ? 'line_through' : ''">
                        {{ app.created_at }}
                    </td>
                    <td class="text-right padding_right_0">
                        <div class="btn btn-default" @click="app.visible = (app.visible == 0 ? 1 : 0)"> 
                            <i :class="app.visible == 1 ? 'fa fa-eye-slash' : 'fa fa-eye'"></i>
                        </div>
                        <div class="btn btn-default margin_right_10" @click="editFeaturedApp(app)"> 
                            <i class="fa fa-pencil"></i>
                        </div>   
                        <div class="btn btn-danger" @click="form.featuredApps.splice(idx, 1)"> 
                            <i class="fa fa-times"></i>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>	
        <!-- table -->


        <modal title="Select an app" effect="fade" width="800" :backdrop=false :value="featuredModal.show" @cancel="resetFeaturedApp()"> 
            <div slot="modal-body" class="modal-body">
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">Choose an app</label>
                    <div class="col-sm-10">
                        <v-select
                            :debounce="250"
                            :on-search="getContentItems"
                            :options="featuredModal.contentItems"
                            v-model="featuredModal.contentItem"
                            placeholder="Search content items"
                            label="titleTranslated"
                        >
                        </v-select>
                    </div>
                </div>
                <!-- form-group -->

                <div v-if="featuredModal.contentItem">
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">App information</label>       
                        <div class="col-sm-10">                                         
                            <div class="app_wrapper">
                                <tabs v-model="activeFeaturedAppTab" nav-style="tabs">
                                    <tab v-for="(appPerLanguage, key, idx) in featuredModal.contentItem.title" :header="key" :key="appPerLanguage"> <!-- :key="appPerLanguage" -->
                                        
                                        <img :src="featuredModal.contentItem.preview" class="img-responsive" />
                                        <div class="app_content">
                                            <strong>{{ appPerLanguage }}</strong>
                                            <div>
                                                {{ featuredModal.contentItem.description[key] }}
                                            </div>
                                        </div>
                                        <div style="clear:both;"></div>

                                    </tab>
                                </tabs>     
                            </div>
                            <!-- app_wrapper -->
                        </div>
                    </div>
                    <!-- form-group -->

                    <hr>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Upload featured banner<br />(600x300 px)</label>
                        <div class="col-sm-10">  

                        	<template v-if="featuredModal.featuredApp.banner">
                        		<img :src="featuredModal.featuredApp.banner" class="img-responsive">
                        		<div class="text-center margin_top_10">
                        			<button class="btn btn-danger min_width_100" @click="featuredModal.featuredApp.banner = ''">
                        				Remove banner
                        			</button>
                        		</div>
                        	</template>

                        	<template v-else>
	                            <dropzone 
	                                id="myVueDropzone"
                                    :url="'/admin/api/portal/featured-app/' + portalId + '/upload-banner'"
	                                :useFontAwesome="true"
	                                :max-number-of-files=1
	                                :thumbnailHeight=400
	                                :thumbnailWidth=600
	                                v-on:vdropzone-success="uploadFeaturedAppBanner">
	                                <input type="hidden" name="_token" :value="token">
	                            </dropzone>
                            </template>

                        </div>
                    </div>
                    <!-- form-group -->

                </div>

            </div>
            <!-- modal-body -->

            <div slot="modal-footer" class="modal-footer">
                <button type="button" class="btn btn-default min_width_100 pull-left" @click="resetFeaturedApp()">Cancel</button>
                <button type="button" class="btn btn-success min_width_100" @click="saveFeaturedApp()">Save</button>
            </div>
            <!-- modal-footer -->

        </modal>
        <!-- end modal --> 


    </div>
</template>

<script>
import { tabs, tab, tabGroup, tabset, modal } from 'vue-strap';
import _ from 'lodash';
import Dropzone from 'vue2-dropzone';

export default {
	
	components: {
		tabs, tab, tabGroup, tabset, modal, Dropzone
	},

    props: {
        form: {},
        featuredModal: {},
        portalId: {}
    },

    data() {
    	return {
    		token: Laravel.csrfToken
    	}
    },

    mounted() {

    },

    computed: {

    	dateToday() {
    	    var date = new Date();
    	    return date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear();
    	},

    	activeFeaturedAppTab() {
    	    return Object.keys(this.featuredModal.contentItem.title).indexOf('en');
    	}
    },

    methods: {

    	getContentItems(search, loading) {
    	    loading(true);
    	    // retrieve searched items
    	    axios.get('/admin/api/portal/contentitems/' + search)
    	        .then(resp => {
    	            this.featuredModal.contentItems = resp.data
    	            loading(false)
    	        });
    	},

    	getContentItem(id) {
    		axios.get('/admin/api/portal/contentitem/' + id)
    		    .then(resp => {
    		    	this.featuredModal.contentItem = resp.data;
    		    });
    	},

    	//newFeaturedApp()
    	editFeaturedApp(featuredApp) {
    		//this.featuredModal.featuredApp.contentItem.id = 
    		//this.featuredModal.contentItem.titleTranslated =
    		this.featuredModal.featuredApp = featuredApp;
    		this.getContentItem(featuredApp.content_item_id);
    		this.featuredModal.edit = true;
    		this.featuredModal.show = true;
    	},

    	uploadFeaturedAppBanner(file, response) {
    		this.featuredModal.featuredApp.banner = response;
    	},

    	saveFeaturedApp() {
    	    var featuredApp = {
    	        content_item_id: this.featuredModal.contentItem.id,
    	        content_item_title: this.featuredModal.contentItem.titleTranslated,
    	        banner: this.featuredModal.featuredApp.banner,
    	        created_at: this.dateToday,
    	        visible: 1
    	    }

    	    // if new item (non-edit) push
    	    if (!this.featuredModal.edit) this.form.featuredApps.push(featuredApp);

    	    // reset modal
    	    this.resetFeaturedApp();
    	},

    	resetFeaturedApp() {
    		this.featuredModal.show = false;
    		this.featuredModal.featuredApp = {};
    		this.featuredModal.contentItem = '';
    		this.featuredModal.contentItems = [];
    	}
    }
}
</script>
