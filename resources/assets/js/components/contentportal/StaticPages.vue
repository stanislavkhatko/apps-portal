<template>
    <div>

        <!-- begin nav-tabs headers -->
        <ul class="nav nav-tabs">
            <li v-for="(language, langIdx) in form.languages" :class="langIdx == 0 ? 'active' : ''">
                <a data-toggle="tab" :href="'#s_page' + langIdx">
                    {{ language.label }}
                </a>
            </li>
        </ul>
        <!-- nav-tabs headers -->


        <!-- begin tab-content -->
        <div class="tab-content">

            <!-- begin tab-pane -->
            <div :id="'s_page' + langIdx" class="tab-pane" v-for="(language, langIdx) in form.languages" :class="langIdx == 0 ? 'in active' : ''">

                <table class="table table-borderless m-b-none table_pages">
                    <thead>
                        <tr>
                            <th>Page type</th>
                            <th style='width:120px;'>Created</th>
                            <th style='width:260px;'></th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(page, idx) in form.staticPages" v-if="page.lang_code == language.value">

                            <tr :class="!page.visible ? 'bg-warning' : ''">
                                
                                <td :class="!page.visible ? 'line_through' : ''">
                                    
                                    <span v-if="page.type === 'disclaimer'">
                                        Disclaimer section (authentication)
                                    </span> 
                                    <span v-if="page.type === 'price-banner'">
                                        Price section (authentication)
                                    </span> 
                                    <span v-if="page.type === 'slider'">
                                        Newsflash slider (header)
                                    </span> 

                                    <!-- pages modals --> 
                                    <modal :title="'Edit ' + page.type" effect="fade" width="800" :value="page.showModal" @cancel="page.showModal = false" :backdrop=false>
                                        <div slot="modal-body" class="modal-body">
                                            <froala :config="froalaConfig" v-model="page.body"></froala>
                                        </div>
                                        <div slot="modal-footer" class="modal-footer">
                                            <button type="button" class="btn btn-default min_width_100 pull-left" @click="page.showModal = false">Cancel</button>
                                            <button type="button" class="btn btn-success min_width_100" @click="page.showModal = false">Save</button>
                                        </div>
                                    </modal>
                                    <!-- end pages modals --> 

                                </td>

                                <td :class="!page.visible ? 'line_through' : ''">
                                    {{ page.created_at }}
                                </td>

                                <td class="text-right">
                                    <div class="btn btn-default" @click="page.visible = !page.visible"> 
                                        <i :class="page.visible ? 'fa fa-eye-slash' : 'fa fa-eye'"></i>
                                    </div>
                                    <div class="btn btn-default margin_right_10" @click="page.showModal = true"> 
                                        <i class="fa fa-pencil"></i>
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

    </div>
</template>

<script>
import { tabs, tab, tabGroup, tabset, modal } from 'vue-strap';
import _ from 'lodash';

export default {
	
	components: {
		tabs, tab, tabGroup, tabset, modal
	},

    props: {
        form: {},
        froalaConfig: {}
    },

    data() {
        return {
            
        }
    },

    mounted() {

    },

    computed: {
        
    },

    methods: {

    }
}
</script>
