<template>
	<div>

        <!-- begin nav-tabs headers -->
        <ul class="nav nav-tabs">
            <li v-for="(language, langIdx) in form.languages" :class="langIdx == 0 ? 'active' : ''">
                <a data-toggle="tab" :href="'#d_page' + langIdx">{{ language.label }}</a>
            </li>
        </ul>
        <!-- nav-tabs headers -->

        <!-- begin tab-content -->
        <div class="tab-content">

            <!-- begin tab-pane -->
            <div :id="'d_page' + langIdx" class="tab-pane" v-for="(language, langIdx) in form.languages" :class="langIdx == 0 ? 'in active' : ''">

                <div :class="hasPagesForLanguage(language.value) ? 'add_bttn_absolute' : ''">
                    <div href="#" class="btn btn-primary" @click="addPage(language.value)">
                        <i class="fa fa-plus"></i>
                    </div> 
                </div>

                <table class="table table-borderless m-b-none table_pages" v-if="hasPagesForLanguage(language.value)">
                    <thead>
                        <tr>
                            <th>Page title</th>
                            <th style='width:120px;'>Created</th>
                            <th style='width:260px;'></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <!-- begin form.pages loop --> 
                        <template v-for="(page, idx) in sortedPages" v-if="page.lang_code == language.value">

                            <tr :class="!page.visible ? 'bg-warning' : ''">
                                
                                <td :class="!page.visible ? 'line_through' : ''">
                                    <template v-if="page.title != ''">
                                        {{ page.title }}
                                    </template>            
                                    <template v-else>
                                        <i>(Empty page title)</i>
                                    </template>    

                                    <!-- pages modals --> 
                                    <modal title="Page editor" effect="fade" width="800" :value="page.showModal" @cancel="page.showModal = false" :backdrop=false>
                                        <div slot="modal-body" class="modal-body">
                                            <input type="text" autocomplete="off" class="form-control" placeholder="Type a page title" v-model="page.title"><br>
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
                                    <div class="btn btn-default position_up" @click="changePagePosition('up', page)"> 
                                        <i class="fa fa-arrow-up"></i>
                                    </div>
                                    <div class="btn btn-default position_down margin_right_10" @click="changePagePosition('down', page)"> 
                                        <i class="fa fa-arrow-down"></i>
                                    </div>
                                    <div class="btn btn-danger" @click="removePage(idx)"> 
                                        <i class="fa fa-times"></i>
                                    </div>
                                </td>

                            </tr>

                        </template>
                        <!-- end form.pages loop -->                             
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

    mounted() {

    },

    computed: {
        dateToday() {
            var date = new Date();
            return date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear();
        },

        sortedPages: function() {
            return this.form.pages.sort(( a, b) => {
                return a.position - b.position;
            });
        }
    },

    methods: {
        hasPagesForLanguage(lang) {
            if (_.filter(this.sortedPages, {'lang_code': lang}).length > 0) {
                return true;
            }
            else {
                return false;
            }            
        },  

        addPage(lang) {
            var pagesArr = _.filter(this.sortedPages, {'lang_code': lang});

            // get new position page, if there are pages, get the last one and add with 1, if the first page, get last position of all pages and add with 1
            var newPosition = (pagesArr.length > 0 ) ? pagesArr[pagesArr.length - 1].position + 0.5 : this.form.pages.length + 1;

            var page = {
                id: 0,
                lang_code: lang,
                visible: false,
                title: '',
                body: '',
                position: newPosition,
                created_at: this.dateToday,
                type: 'dynamic',
                showModal: false
            }

            this.form.pages.push(page);

            this.resetPagePositions();
        },

        removePage(idx) {
            this.form.pages.splice(idx, 1);

            this.resetPagePositions();
        },
        
        changePagePosition(direction, page) {     
            if (direction == 'up') page.position = page.position - 1.5;
            if (direction == "down") page.position = page.position + 1.5;

            this.resetPagePositions();
        },

        resetPagePositions() {
            var i = 0;
            _.forEach(this.sortedPages, function(page) {
                i += 1;
                page.position = i;
            });
        }
    }
}
</script>
