<template>
	<!-- pages modals --> 
	<modal title="Manage Content items" :backdrop=false :value="contentItemsManager.showModal" @cancel="cancelContentItemsManager">
	    <div slot="modal-body" class="modal-body">
	        <div class="form-group margin_bottom_5">
	            <label class="col-sm-2 control-label padding_right2_0">
	                <span v-if="this.content_items.provider.options.length > 0">Available content items</span>
	            </label>
	            <div class="col-sm-10">
	                <template v-if="this.content_items.provider.options.length > 0">
	                    <v-select
	                        multiple
	                        :options="content_items.provider.options"
	                        v-model="content_items.provider.selected"
	                        placeholder="Select available content items from provider..."
	                        label="titleTranslated">
	                    </v-select>
	                    <div style="clear:both;"></div>
	                    <button 
	                        @click="addProviderItemsToLocalItems"
	                        class="btn btn-primary with_cursor margin_top_10 pull-right" 
	                        :class="!content_items.provider.selected.length > 0 ? 'disabled' : ''">
	                        <i class="fa fa-plus"></i> &nbsp;&nbsp;Add selection
	                    </button>
	                </template>
	                <template v-else>
	                    <div class="text-center">
	                        <strong><i>No new content items available.<br />Add new content items via Provider Content overview menu.</i></strong>
	                    </div>                                                    
	                </template>
	            </div>
	        </div>
	        <!-- form-group -->

	        <div class="row">
	            <div class="col-sm-offset-2 col-sm-10">
	                <hr />
	            </div>
	        </div>
	        <!-- hr -->

	        <div class="form-group">
	            <label class="col-sm-2 control-label padding_right2_0">
	                <span v-if="content_items.local.length > 0">Content items in use</span>
	                <div class="remove_link" @click="removeAllItemsFromList()">(<i class="fa fa-times"></i> <span class="link_txt">Remove all items</span>)</div>
	            </label>
	            <div class="col-sm-10">
	                <table class="table table-borderless m-b-none" v-if="content_items.local.length > 0">
	                    <thead>
	                        <tr>
	                            <th style="width: 85px;">Icon</th>
	                            <th>Info</th>
	                            <th>provider</th>
	                            <th style='width:120px;'>Created</th>
	                            <th style='width:100px;'></th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                        <template v-for="(content_item, idx) in content_items.local">
	                            <tr>
	                                <td>
	                                    <img :src="content_item.preview" class="img-responsive">
	                                </td>
	                                <td>
	                                    <strong>{{ content_item.title['en'] }}</strong>
	                                    <div class="description" v-if="content_item.description['en']">
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
	                                    <div class="btn btn-danger" @click="removeContentItemFromCategory(idx, content_item.id)"> 
	                                        <i class="fa fa-times"></i>
	                                    </div>
	                                </td>
	                            </tr>
	                        </template>
	                    </tbody>
	                </table>
	                
	                <div class="text-right small" v-if="content_items.local.length > 0">
	                    <i>(* Removing items will not permanently delete content items<br />Content items can be permanently deleted via Provider Content overview menu)</i>
	                </div>

	                <div v-if="helpers.spinner.loadingItems" class="text-center">
	                	<i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw bttn_spinner"></i>
	                </div>

	                <div v-if="!helpers.spinner.loadingItems && content_items.local.length == 0" class="text-center">
	                	<strong><i>No content items in use</i></strong>
	                </div>

	            </div>
	        </div>

	    </div>
	    <!-- body -->                                    
	    <div slot="modal-footer" class="modal-footer">
	        <button type="button" class="btn btn-default min_width_100 pull-left" @click="cancelContentItemsManager">Cancel</button>

	        <button class="btn btn-success min_width_100"
	                @click="syncContentItems()" 
	                :class="content_items.local.length == 0 || helpers.spinner.save ? 'disabled' : ''"> 
	            <span v-show="!helpers.spinner.save">Save content items</span>
	            <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw bttn_spinner" v-show="helpers.spinner.save"></i>
	        </button>    
	    </div>
	</modal>
	<!-- end pages modals --> 

</template>

<script>
import { modal, select, tooltip } from 'vue-strap';
import _ from 'lodash';

export default {
	
	components: {
		modal, tooltip, vSelect2: select
	},

    props: {
    	contentItemsManager: ''
    },

    data() {
    	return {
    		helpers: {
    		    spinner: {
    		    	loadingItems: true,
    		        save: false
    		    }    		    
    		},  

    		content_items: {
    		    local: [],                    
    		    provider: {
    		        selected: '',
    		        options: []
    		    }
    		}  
    	}
    },

    methods: {
    	
    	// fetch contentitems for category
    	loadContentItems() {

    	    axios.get('/admin/api/local-content-type/local-category/' + this.contentItemsManager.category.id + '/category/' + this.contentItemsManager.category.provider_category_id + '/content-items')
    	        .then(resp => {
    	            this.content_items.local = resp.data.localCategoryItems;
    	            this.content_items.provider.options = resp.data.categoryItems;
    	            this.helpers.spinner.loadingItems = false;
    	        });
    	},


    	// add content item to list of local content items
    	addProviderItemsToLocalItems() {
    	    var me = this;

    	    // merge choosen provider items with local items list
    	    this.content_items.local = _.concat(this.content_items.provider.selected, this.content_items.local);

    	    // if item added from provider, clear from provider options
    	    this.content_items.provider.options = _.difference(me.content_items.provider.options, me.content_items.local);

    	    // clear
    	    this.content_items.provider.selected = [];
    	},


    	// add local item back to provider list, then remove from local list
    	removeContentItemFromCategory(idx, contentItemID) {
    	    
    	    this.content_items.provider.options.push(this.content_items.local[idx]);
    	    this.content_items.local.splice(idx, 1);
    	},

    	removeAllItemsFromList() {
    		this.content_items.provider.options = _.concat(this.content_items.provider.options, this.content_items.local);
    		//this.content_items.provider.options.push(this.content_items.local);
    		this.content_items.local = [];
    	},

    	// reset modal
    	cancelContentItemsManager() {    	    
    	    this.contentItemsManager.showModal = false;

    	    // timeout, anders worden elementen nog getoond tijdens fadeout modal
    	    var me = this;
    	    setTimeout(function() {
    	    	me.contentItemsManager.category = {};
    	    	me.content_items.local = [];
    	    	me.content_items.provider.options = [];
    	    	me.content_items.provider.selected = '';
    	    	me.helpers.spinner.loadingItems = true;
    	    }, 1000);
    	    
    	}, 


    	//  save/sync selected content items
    	syncContentItems() {
    	    var me = this;
    	    this.helpers.spinner.save = true;

    	    axios.post('/admin/api/local-content-type/content-items/sync', {categoryId: this.contentItemsManager.category.id ,contentItems: _.map(me.content_items.local, 'id')})
    	        .then((response) => {
    	            if (response.data) {
    	            	this.$emit('emitUpdateContentItemsCount', {content_items_count: this.content_items.local.length, category_id: this.contentItemsManager.category.id});
    	            	this.helpers.spinner.save = false;
    	            	this.cancelContentItemsManager();
    	            }
    	        });
    	},
    },

    watch: {
        'contentItemsManager.showModal': function(val) {
        	if (val == true) this.loadContentItems();
        }
    }
}
</script>