<template>
    <div>
        
        <template v-if="type === 'colorPicker'">
            
            <div class="form-group">

                <label class="col-sm-2 control-label">{{ label }}</label>

                <div class="col-sm-10">
                    
                    <input 
                        type="text" 
                        autocomplete="off"
                        class="form-control" 
                        placeholder="Choose a color" 
                        v-model="model[item].hex" />
                    
                    <div 
                        class="color_block" 
                        v-bind:style="{ backgroundColor: model[item].hex }" 
                        @click="helpers.showColorPicker = true"
                    >
                        <i class="fa fa-eyedropper" aria-hidden="true" v-if="!model[item].hex"></i>
                    </div>
                    <!-- color block -->
                    
                    <div class="color_picker_wrapper" v-if="helpers.showColorPicker">
                        
                        <div class="color_picker_header">
                            <i class="fa fa-times" @click="helpers.showColorPicker = false"></i>
                        </div>
                        <!-- color_picker_header -->

                        <chrome-picker class="color_picker" v-model="model[item]" />
                        <!-- color-picker component -->

                    </div>
                    <!-- color_picker_wrapper -->
                    
                </div>

            </div>
            <!-- form-group text-color -->
            
        </template>
        <!-- COLOR PICKER INPUT -->



        <template v-if="type === 'numberInput'">

            <div class="form-group">
                <label class="col-sm-2 control-label">{{ label }}</label>

                <div class="col-sm-10">
                    <div class="input-group">
                      <input type="number" class="form-control" v-model="model[item]" />
                      <span class="input-group-addon">{{ addonLabel }}</span>
                    </div>                                                 
                </div>
            </div>
            <!-- form-group -->

        </template>
        <!-- NUMBER INPUT -->



        <template v-if="type === 'textInput'">

            <div class="form-group">
                <label class="col-sm-2 control-label">{{ label }}</label>

                <div class="col-sm-10">
                    <input type="text" class="form-control" :placeholder="placeholder" v-model="model[item]" />                                
                </div>
            </div>
            <!-- form-group -->

        </template>
        <!-- TEXT INPUT -->



        <template v-if="type === 'alignSelect'">

            <div class="form-group">
                <label class="col-sm-2 control-label">{{ label }}</label>

                <div class="col-sm-10">
                    <v-select 
                        v-model="model[item]" 
                        :options="alignment.options" 
                        placeholder="Choose an alignment"
                      ></v-select>
                </div>
            </div>
            <!-- form-group -->

        </template>
        <!-- ALIGNMENT SELECT -->



        <template v-if="type === 'floatSelect'">

            <div class="form-group">
                <label class="col-sm-2 control-label">{{ label }}</label>

                <div class="col-sm-10">
                    <v-select 
                        v-model="model[item]" 
                        :options="float.options" 
                        placeholder="Choose a position"
                      ></v-select>
                </div>
            </div>
            <!-- form-group -->

        </template>
        <!-- FLOAT SELECT -->

        

        <template v-if="type === 'fontWeightSelect'">

            <div class="form-group">
                <label class="col-sm-2 control-label">{{ label }}</label>

                <div class="col-sm-10">
                    <v-select 
                        v-model="model[item]" 
                        :options="fontWeight.options" 
                        placeholder="Choose a font weight"
                      ></v-select>
                </div>
            </div>
            <!-- form-group -->

        </template>
        <!-- FONT WEIGHT SELECT -->



        <template v-if="type === 'fontFamilySelect'">

            <div class="form-group">
                <label class="col-sm-2 control-label">{{ label }}</label>

                <div class="col-sm-10">
                    <v-select 
                        v-model="model[item]" 
                        :options="fontFamily.options" 
                        placeholder="Choose a font family"
                      ></v-select>
                </div>
            </div>
            <!-- form-group -->

        </template>
        <!-- FONT FAMILY SELECT -->


        <template v-if="type === 'fontFamilyGlobalSelect'">

            <div class="form-group">
                <label class="col-sm-2 control-label">{{ label }}</label>

                <div class="col-sm-10">
                    <v-select 
                        v-model="model[item]" 
                        :options="fontFamilyGlobal.options" 
                        placeholder="Choose a font family"
                      ></v-select>
                </div>
            </div>
            <!-- form-group -->

        </template>
        <!-- FONT FAMILY SELECT -->



        <template v-if="type === 'yesNoSelect'">

            <div class="form-group">
                <label class="col-sm-2 control-label">{{ label }}</label>

                <div class="col-sm-10">
                    <v-select 
                        v-model="model[item]" 
                        :options="yesNo.options" 
                        placeholder="Choose an option (yes/no)"
                      ></v-select>
                </div>
            </div>
            <!-- form-group -->

        </template>
        <!-- YES NO SELECT -->



        <template v-if="type == 'verticalAlignSelect'">

            <div class="form-group">
                <label class="col-sm-2 control-label">{{ label }}</label>

                <div class="col-sm-10">
                    <v-select 
                        v-model="model[item]" 
                        :options="verticalAlign.options" 
                        placeholder="Vertical alignment"
                      ></v-select>
                </div>
            </div>
            <!-- form-group -->

        </template>
        <!-- verticalAlignSelect -->




        <template v-if="type == 'horizontalAlignSelect'">

            <div class="form-group">
                <label class="col-sm-2 control-label">{{ label }}</label>

                <div class="col-sm-10">
                    <v-select 
                        v-model="model[item]" 
                        :options="horizontalAlign.options" 
                        placeholder="Horizontal alignment"
                      ></v-select>
                </div>
            </div>
            <!-- form-group -->

        </template>
        <!-- horizontalAlignSelect -->

    </div>
</template>

<script>
import { Chrome } from 'vue-color'
import _ from 'lodash';

export default {
	
	components: {
		'chrome-picker': Chrome
	},

    props: {
        type: String,
        label: String,
        addonLabel: String,
        placeholder: String,
        item: String,
        model: {}
    },

    data() {
        return {
            helpers: {
                showColorPicker: false
            },
            alignment: {
                options: [
                    'left',
                    'center',
                    'right'
                ]
            },
            float: {
                options: [
                    'left',
                    'right'
                ]
            },
            fontFamily: {
                options: [
                    'Arial',
                    'Helvetica',
                    'Helvetica Neue',
                    'Times New Roman',
                    'Times',
                    'Courier New',
                    'Courier',
                    'Verdana',
                    'Georgia',
                    'Use parent font'                   
                ]
            },
            fontFamilyGlobal: {
                options: [
                    'Arial',
                    'Helvetica',
                    'Helvetica Neue',
                    'Times New Roman',
                    'Times',
                    'Courier New',
                    'Courier',
                    'Verdana',
                    'Georgia',                  
                ]
            },
            fontWeight: {
                options: [
                    'lighter',
                    'normal',
                    'bold'
                ]
            },
            yesNo: {
                options: [
                    'yes',
                    'no'
                ]
            },
            verticalAlign: {
                options: [
                    'top',
                    'middle',
                    'bottom'
                ]
            },
            horizontalAlign: {
                options: [
                    'left',
                    'center',
                    'right'
                ]
            }
        }
    },

    mounted() {
        //this.$emit('update:model', test_color)
    },

    computed: {

    },

    methods: {

    }
}
</script>
