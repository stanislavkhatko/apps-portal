
require('./bootstrap');

/**
 * Load all the javascript tricks that we use in this portal.
 */
require('./foundation');

//Vendor libs
import vSelect from 'vue-select'

Vue.component('v-select', vSelect);

require('froala-editor/js/froala_editor.pkgd.min');
import VueFroala from 'vue-froala-wysiwyg'

Vue.use(VueFroala);

import {carousel, slider} from 'vue-strap';
// import Flickity from 'vue-flickity';

//App components.
Vue.component('portalForm', require('./components/contentportal/Form.vue'));
Vue.component('staticPages', require('./components/contentportal/StaticPages.vue'));
Vue.component('dynamicPages', require('./components/contentportal/DynamicPages.vue'));

Vue.component('portalThemeForm', require('./components/contentportaltheme/Form.vue'));
Vue.component('formInput', require('./components/contentportaltheme/FormInput.vue'));

Vue.component('contentItemForm', require('./components/contentitem/Form.vue'));
Vue.component('categoryForm', require('./components/category/Form.vue'));
Vue.component('contentTypeForm', require('./components/contenttype/Form.vue'));

Vue.component('localContentTypeForm', require('./components/localcontenttype/Form.vue'));

Vue.component('translationForm', require('./components/translation/Form.vue'));

new Vue({
    components: {
        carousel,
        slider,
        //Flickity
    },
    el: '#app'
});
