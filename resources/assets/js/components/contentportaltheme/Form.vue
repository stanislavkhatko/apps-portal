<template>
    <div class="col-xs-12 app-content portal_form">
        <div class="panel panel-default">

            <div class="panel-heading">
                <div>
                    Portal theme
                </div>

            </div>
            <!-- panel heading -->


            <div class="panel-body">
                <div class="form-horizontal margin_top_20">


                    <div class="form-group">
                        <label class="col-sm-2 control-label">Choose a theme</label>

                        <div class="col-sm-10">
                            <v-select2 v-model="themes.selected.id" :options="themes.options" options-value="id"
                                       options-label="name" placeholder="Select a theme"
                                       class="width_100_percent"></v-select2>
                        </div>
                    </div>
                    <!-- portal name section -->


                    <template v-if="themes.selected.id">

                        <div class="row">
                            <div class="col-sm-offset-2 col-sm-10">
                                <hr/>
                            </div>
                        </div>
                        <!-- hr -->

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Theme global<br/>options</label>

                            <div class="col-sm-10">
                                <tabs v-model="helpers.activeTab" nav-style="tabs" class="tabs_with_accordion"
                                      justified>

                                    <tab header="Header">

                                        <accordion :one-at-atime="true" type="info">

                                            <panel header="Style" is-open type="primary">

                                                <form-input
                                                        type="colorPicker"
                                                        label="Background color"
                                                        item="background_color"
                                                        :model="theme.components.header.style">
                                                </form-input>

                                                <form-input
                                                        type="alignSelect"
                                                        label="Text alignment"
                                                        item="text_align"
                                                        :model="theme.components.header.style">
                                                </form-input>

                                                <form-input
                                                        type="colorPicker"
                                                        label="Text color"
                                                        item="color"
                                                        :model="theme.components.header.style">
                                                </form-input>

                                                <form-input
                                                        type="numberInput"
                                                        label="Font size"
                                                        addonLabel="pixels"
                                                        item="font_size"
                                                        :model="theme.components.header.style">
                                                </form-input>

                                                <form-input
                                                        type="fontWeightSelect"
                                                        label="Font weight"
                                                        item="font_weight"
                                                        :model="theme.components.header.style">
                                                </form-input>

                                                <form-input
                                                        type="numberInput"
                                                        label="Border bottom"
                                                        addonLabel="pixels"
                                                        item="border_bottom_size"
                                                        :model="theme.components.header.style">
                                                </form-input>

                                                <form-input
                                                        type="colorPicker"
                                                        label="Border color"
                                                        item="border_color"
                                                        :model="theme.components.header.style">
                                                </form-input>

                                                <form-input
                                                        type="numberInput"
                                                        label="Min. Height"
                                                        addonLabel="pixels"
                                                        item="height"
                                                        :model="theme.components.header.style">
                                                </form-input>

                                            </panel>

                                        </accordion>

                                    </tab>

                                    <!-- Header -->

                                    <tab header="Navbar (menu)">

                                        <accordion :one-at-atime="true" type="info">

                                            <panel header="Brand title/logo" is-open type="primary">

                                                <form-input
                                                        type="textInput"
                                                        label="Brand title"
                                                        placeholder="Type a title"
                                                        item="title"
                                                        :model="theme.components.navbar.content">
                                                </form-input>


                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">
                                                        Brand logo<br>
                                                        <small><i>(will be auto resized to fit navbar)</i></small>
                                                    </label>

                                                    <div class="col-sm-10">

                                                        <template v-if="theme.components.navbar.content.image">
                                                            <img :src="theme.components.navbar.content.image"
                                                                 class="img-responsive">
                                                            <div class="text-center margin_top_10">
                                                                <button class="btn btn-danger min_width_100"
                                                                        @click="theme.components.navbar.content.image = ''">
                                                                    Remove logo
                                                                </button>
                                                            </div>
                                                        </template>

                                                        <template v-else>
                                                            <dropzone
                                                                    id="myVueDropzone2"
                                                                    :url="navbarUploadRoute"
                                                                    :useFontAwesome="true"
                                                                    :max-number-of-files=1
                                                                    v-on:vdropzone-success="uploadNavbarImage">
                                                                <input type="hidden" name="_token" :value="token">
                                                            </dropzone>
                                                        </template>

                                                    </div>
                                                </div>
                                                <!-- form-group -->

                                            </panel>

                                            <panel header="Brand style">

                                                <form-input
                                                        type="alignSelect"
                                                        label="Brand alignment"
                                                        item="brand_text_align"
                                                        :model="theme.components.navbar.style">
                                                </form-input>

                                                <form-input
                                                        type="colorPicker"
                                                        label="Brand text color"
                                                        item="brand_color"
                                                        :model="theme.components.navbar.style">
                                                </form-input>

                                                <form-input
                                                        type="numberInput"
                                                        label="Brand font size"
                                                        addonLabel="pixels"
                                                        item="brand_font_size"
                                                        :model="theme.components.navbar.style">
                                                </form-input>

                                                <form-input
                                                        type="fontWeightSelect"
                                                        label="Brand font weight"
                                                        item="brand_font_weight"
                                                        :model="theme.components.navbar.style">
                                                </form-input>

                                            </panel>

                                            <panel header="Navbar style">

                                                <form-input
                                                        type="colorPicker"
                                                        label="Header background color"
                                                        item="background_color"
                                                        :model="theme.components.header.style">
                                                </form-input>

                                                <form-input
                                                        type="colorPicker"
                                                        label="Navbar background color"
                                                        item="background_color"
                                                        :model="theme.components.navbar.style">
                                                </form-input>

                                                <form-input
                                                        type="colorPicker"
                                                        label="Text color"
                                                        item="color"
                                                        :model="theme.components.navbar.style">
                                                </form-input>

                                                <form-input
                                                        type="numberInput"
                                                        label="Font size"
                                                        addonLabel="pixels"
                                                        item="font_size"
                                                        :model="theme.components.navbar.style">
                                                </form-input>

                                                <form-input
                                                        type="fontWeightSelect"
                                                        label="Font weight"
                                                        item="font_weight"
                                                        :model="theme.components.navbar.style">
                                                </form-input>

                                                <form-input
                                                        type="numberInput"
                                                        label="Border bottom"
                                                        addonLabel="pixels"
                                                        item="border_bottom_size"
                                                        :model="theme.components.navbar.style">
                                                </form-input>

                                                <form-input
                                                        type="colorPicker"
                                                        label="Border color"
                                                        item="border_color"
                                                        :model="theme.components.navbar.style">
                                                </form-input>

                                                <form-input
                                                        type="numberInput"
                                                        label="Min. Height"
                                                        addonLabel="pixels"
                                                        item="height"
                                                        :model="theme.components.navbar.style">
                                                </form-input>

                                            </panel>

                                            <panel header="Menu position (hamburger)">

                                                <form-input
                                                        type="floatSelect"
                                                        label="Position"
                                                        item="menu_float"
                                                        :model="theme.components.navbar.style">
                                                </form-input>

                                            </panel>

                                        </accordion>

                                    </tab>
                                    <!-- tab Navbar -->


                                    <tab header="Body (outer)">

                                        <accordion :one-at-atime="true" type="info">

                                            <panel header="Style" is-open type="primary">

                                                <form-input
                                                        type="colorPicker"
                                                        label="Background color"
                                                        item="background_color"
                                                        :model="theme.components.body.style">
                                                </form-input>

                                            </panel>
                                            <!-- panel -->

                                        </accordion>
                                        <!-- accordion -->

                                    </tab>

                                    <tab header="Body (center)">

                                        <accordion :one-at-atime="true" type="info">

                                            <panel header="Style" is-open type="primary">


                                                <form-input
                                                        type="colorPicker"
                                                        label="Background color"
                                                        item="background_color"
                                                        :model="theme.components.center.style">
                                                </form-input>

                                                <form-input
                                                        type="colorPicker"
                                                        label="Font color"
                                                        item="content_color"
                                                        :model="theme.components.center.style">
                                                </form-input>

                                                <form-input
                                                        type="colorPicker"
                                                        label="Primary text color"
                                                        item="content_primary_color"
                                                        :model="theme.components.center.style">
                                                </form-input>

                                                <form-input
                                                        type="colorPicker"
                                                        label="Secondary text color"
                                                        item="content_secondary_color"
                                                        :model="theme.components.center.style">
                                                </form-input>

                                                <form-input
                                                        type="numberInput"
                                                        label="Content width"
                                                        addonLabel="pixels"
                                                        item="content_width"
                                                        :model="theme.components.center.style">
                                                </form-input>

                                                <form-input
                                                        type="numberInput"
                                                        label="Border (left + right)"
                                                        addonLabel="pixels"
                                                        item="border_left_right_size"
                                                        :model="theme.components.center.style">
                                                </form-input>

                                                <form-input
                                                        type="colorPicker"
                                                        label="Border color"
                                                        item="border_color"
                                                        :model="theme.components.center.style">
                                                </form-input>

                                            </panel>
                                            <!-- panel -->

                                            <panel header="Buttons">

                                                <form-input
                                                        type="numberInput"
                                                        label="Button font size"
                                                        addonLabel="pixels"
                                                        item="button_font_size"
                                                        :model="theme.components.center.style">
                                                </form-input>

                                                <form-input
                                                        type="colorPicker"
                                                        label="Button text color"
                                                        item="button_color"
                                                        :model="theme.components.center.style">
                                                </form-input>

                                                <form-input
                                                        type="colorPicker"
                                                        label="Background color"
                                                        item="button_background_color"
                                                        :model="theme.components.center.style">
                                                </form-input>

                                                <form-input
                                                        type="numberInput"
                                                        label="Border size"
                                                        addonLabel="pixels"
                                                        item="button_border_size"
                                                        :model="theme.components.center.style">
                                                </form-input>

                                                <form-input
                                                        type="colorPicker"
                                                        label="Border color"
                                                        item="button_border_color"
                                                        :model="theme.components.center.style">
                                                </form-input>

                                            </panel>
                                            <!-- panel -->

                                        </accordion>
                                        <!-- accordion -->

                                    </tab>

                                    <tab header="Footer">

                                        <accordion :one-at-atime="true" type="info">

                                            <panel header="Text / Image" is-open type="primary">

                                                <form-input
                                                        type="textInput"
                                                        label="Text"
                                                        placeholder="Type a text"
                                                        item="text"
                                                        :model="theme.components.footer.content">
                                                </form-input>


                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">
                                                        Image<br>
                                                        <small><i>(will be auto resized to fit footer)</i></small>
                                                    </label>

                                                    <div class="col-sm-10">

                                                        <template v-if="theme.components.footer.content.image">
                                                            <img :src="theme.components.footer.content.image"
                                                                 class="img-responsive">
                                                            <div class="text-center margin_top_10">
                                                                <button class="btn btn-danger min_width_100"
                                                                        @click="theme.components.footer.content.image = ''">
                                                                    Remove image
                                                                </button>
                                                            </div>
                                                        </template>

                                                        <template v-else>
                                                            <dropzone
                                                                    id="myVueDropzone3"
                                                                    :url="footerUploadRoute"
                                                                    :useFontAwesome="true"
                                                                    :max-number-of-files=1
                                                                    v-on:vdropzone-success="uploadFooterImage">
                                                                <input type="hidden" name="_token" :value="token">
                                                            </dropzone>
                                                        </template>

                                                    </div>
                                                </div>
                                                <!-- form-group -->

                                            </panel>

                                            <panel header="Style">

                                                <form-input
                                                        type="colorPicker"
                                                        label="Background color"
                                                        item="background_color"
                                                        :model="theme.components.footer.style">
                                                </form-input>

                                                <form-input
                                                        type="alignSelect"
                                                        label="Text alignment"
                                                        item="text_align"
                                                        :model="theme.components.footer.style">
                                                </form-input>

                                                <form-input
                                                        type="colorPicker"
                                                        label="Text color"
                                                        item="color"
                                                        :model="theme.components.footer.style">
                                                </form-input>

                                                <form-input
                                                        type="numberInput"
                                                        label="Font size"
                                                        addonLabel="pixels"
                                                        item="font_size"
                                                        :model="theme.components.footer.style">
                                                </form-input>

                                                <form-input
                                                        type="fontWeightSelect"
                                                        label="Font weight"
                                                        item="font_weight"
                                                        :model="theme.components.footer.style">
                                                </form-input>

                                                <form-input
                                                        type="numberInput"
                                                        label="Border top"
                                                        addonLabel="pixels"
                                                        item="border_top_size"
                                                        :model="theme.components.footer.style">
                                                </form-input>

                                                <form-input
                                                        type="colorPicker"
                                                        label="Border color"
                                                        item="border_color"
                                                        :model="theme.components.footer.style">
                                                </form-input>

                                                <form-input
                                                        type="numberInput"
                                                        label="Min. Height"
                                                        addonLabel="pixels"
                                                        item="height"
                                                        :model="theme.components.footer.style">
                                                </form-input>

                                            </panel>

                                        </accordion>

                                    </tab>

                                </tabs>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-offset-2 col-sm-10">
                                <hr/>
                            </div>
                        </div>
                        <!-- hr -->


                        <template v-if="hybrideThemeIsSelected">

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Theme specific<br/>options</label>

                                <div class="col-sm-10">
                                    <tabs v-model="helpers.activeTab2" nav-style="tabs" class="tabs_with_accordion"
                                          justified>

                                        <tab header="General">

                                            <accordion :one-at-atime="true" type="info">

                                                <panel header="Global style" is-open type="primary">

                                                    <form-input
                                                            type="fontFamilyGlobalSelect"
                                                            label="font family"
                                                            item="font_family"
                                                            :model="theme.components2.global.style">
                                                    </form-input>

                                                    <form-input
                                                            type="textInput"
                                                            label="Google font url"
                                                            placeholder="Link of a google font"
                                                            item="font_family_web"
                                                            :model="theme.components2.global.style">
                                                    </form-input>

                                                    <form-input
                                                            type="textInput"
                                                            label="Google font name"
                                                            placeholder="Name of the google font"
                                                            item="font_family_web_name"
                                                            :model="theme.components2.global.style">
                                                    </form-input>

                                                    <small>(* A filled in google font has priority over the normal font
                                                        family dropdown above)
                                                    </small>

                                                </panel>

                                            </accordion>

                                        </tab>
                                        <!-- Header -->


                                        <tab header="Content types">

                                            <accordion :one-at-atime="true" type="info">

                                                <panel header="Header" is-open type="primary">

                                                    <form-input
                                                            type="yesNoSelect"
                                                            label="Header visible"
                                                            item="header_visible"
                                                            :model="theme.components2.content_type.header">
                                                    </form-input>
                                                </panel>

                                                <panel header="Header title">

                                                    <form-input
                                                            type="fontFamilySelect"
                                                            label="Font family"
                                                            item="font_family"
                                                            :model="theme.components2.content_type.header.title">
                                                    </form-input>

                                                    <form-input
                                                            type="textInput"
                                                            label="Google font url"
                                                            placeholder="Link of the google font..."
                                                            item="font_family_web"
                                                            :model="theme.components2.content_type.header.title">
                                                    </form-input>

                                                    <form-input
                                                            type="textInput"
                                                            label="Google font name"
                                                            placeholder="Name of the google font..."
                                                            item="font_family_web_name"
                                                            :model="theme.components2.content_type.header.title">
                                                    </form-input>

                                                    <small>(* A filled in google font has priority over the normal font
                                                        family dropdown above)
                                                    </small>

                                                    <form-input
                                                            type="numberInput"
                                                            label="Font size"
                                                            addonLabel="pixels"
                                                            item="font_size"
                                                            :model="theme.components2.content_type.header.title">
                                                    </form-input>

                                                    <form-input
                                                            type="colorPicker"
                                                            label="Text Color"
                                                            item="color"
                                                            :model="theme.components2.content_type.header.title">
                                                    </form-input>
                                                    <small>(* if text color is empty, text will be transparant if a
                                                        background image is used for the header)
                                                    </small>

                                                    <form-input
                                                            type="colorPicker"
                                                            label="Background color"
                                                            item="background_color"
                                                            :model="theme.components2.content_type.header.title">
                                                    </form-input>

                                                    <form-input
                                                            type="horizontalAlignSelect"
                                                            label="Horizontal align"
                                                            item="horizontal_position"
                                                            :model="theme.components2.content_type.header.title">
                                                    </form-input>

                                                    <form-input
                                                            type="verticalAlignSelect"
                                                            label="Vertical align"
                                                            item="vertical_position"
                                                            :model="theme.components2.content_type.header.title">
                                                    </form-input>

                                                </panel>

                                                <panel header="Header background">

                                                    <template
                                                            v-for="(item, idx) in theme.components2.content_type.header.background">

                                                        <div class="row">
                                                            <label class="col-sm-2 control-label">
                                                                Content type
                                                            </label>
                                                            <div class="col-sm-10 pad_top_7_marg_bot_15">
                                                                <strong>{{ item.name }}</strong>
                                                            </div>
                                                        </div>

                                                        <form-input
                                                                type="colorPicker"
                                                                label="Background color"
                                                                item="background_color"
                                                                :model="theme.components2.content_type.header.background[idx]">
                                                        </form-input>

                                                        <form-input
                                                                type="numberInput"
                                                                label="Background image opacity"
                                                                addonLabel="%"
                                                                item="background_image_opacity"
                                                                :model="theme.components2.content_type.header.background[idx]">
                                                        </form-input>

                                                        <div class="form-group">

                                                            <label class="col-sm-2 control-label">
                                                                Background images<br>
                                                                <small><i>(will be auto resized to fit navbar)</i>
                                                                </small>
                                                            </label>

                                                            <div class="col-sm-10">

                                                                <template
                                                                        v-if="theme.components2.content_type.header.background[idx].background_image">
                                                                    <img :src="'/storage/' + theme.components2.content_type.header.background[idx].background_image"
                                                                         class="img-responsive">
                                                                    <div class="text-center margin_top_10">
                                                                        <button class="btn btn-danger min_width_100"
                                                                                @click="theme.components2.content_type.header.background[idx].background_image = ''">
                                                                            Remove background image
                                                                        </button>
                                                                    </div>
                                                                </template>

                                                                <template v-else>
                                                                    <dropzone
                                                                            :id="'myVueDropzoneForContentType_' + idx"
                                                                            :url="'/admin/api/portal-theme/contentTypeHeader/' + idx + '/upload'"
                                                                            :useFontAwesome="true"
                                                                            :max-number-of-files=1
                                                                            v-on:vdropzone-success="uploadContentTypeHeaderImage">
                                                                        <input type="hidden" name="_token"
                                                                               :value="token">
                                                                    </dropzone>
                                                                    <br/>
                                                                </template>

                                                            </div>
                                                        </div>
                                                        <!-- form-group -->

                                                        <hr/>

                                                    </template>

                                                </panel>

                                                <panel header="Header more button">

                                                    <form-input
                                                            type="fontFamilySelect"
                                                            label="Font family"
                                                            item="font_family"
                                                            :model="theme.components2.content_type.header.more">
                                                    </form-input>

                                                    <form-input
                                                            type="textInput"
                                                            label="Google font"
                                                            placeholder="Link of a google font"
                                                            item="font_family_web"
                                                            :model="theme.components2.content_type.header.more">
                                                    </form-input>

                                                    <form-input
                                                            type="textInput"
                                                            label="Google font name"
                                                            placeholder="Name of the google font..."
                                                            item="font_family_web_name"
                                                            :model="theme.components2.content_type.header.more">
                                                    </form-input>

                                                    <small>(* A filled in google font has priority over the normal font
                                                        family dropdown above)
                                                    </small>

                                                    <form-input
                                                            type="numberInput"
                                                            label="Font size"
                                                            addonLabel="pixels"
                                                            item="font_size"
                                                            :model="theme.components2.content_type.header.more">
                                                    </form-input>

                                                    <form-input
                                                            type="colorPicker"
                                                            label="Background color"
                                                            item="background_color"
                                                            :model="theme.components2.content_type.header.more">
                                                    </form-input>

                                                    <form-input
                                                            type="colorPicker"
                                                            label="Text Color"
                                                            item="color"
                                                            :model="theme.components2.content_type.header.more">
                                                    </form-input>

                                                </panel>

                                            </accordion>

                                        </tab>
                                        <!-- tab Navbar -->


                                        <tab header="Categories">

                                            <accordion :one-at-atime="true" type="info">

                                                <panel header="Categories" is-open type="primary">

                                                    <form-input
                                                            type="yesNoSelect"
                                                            label="Show categories"
                                                            item="visible"
                                                            :model="theme.components2.categories">
                                                    </form-input>

                                                    <small>(* If no, submenu with categories and categories view won't
                                                        be displayed)
                                                    </small>

                                                </panel>

                                                <panel header="Header title">

                                                    <form-input
                                                            type="fontFamilySelect"
                                                            label="Font family"
                                                            item="font_family"
                                                            :model="theme.components2.categories.header.title">
                                                    </form-input>

                                                    <form-input
                                                            type="textInput"
                                                            label="Google font"
                                                            placeholder="Link of a google font"
                                                            item="font_family_web"
                                                            :model="theme.components2.categories.header.title">
                                                    </form-input>

                                                    <form-input
                                                            type="textInput"
                                                            label="Google font name"
                                                            placeholder="Name of the google font..."
                                                            item="font_family_web_name"
                                                            :model="theme.components2.categories.header.title">
                                                    </form-input>

                                                    <small>(* A filled in google font has priority over the normal font
                                                        family dropdown above)
                                                    </small>

                                                    <form-input
                                                            type="numberInput"
                                                            label="Font size"
                                                            addonLabel="pixels"
                                                            item="font_size"
                                                            :model="theme.components2.categories.header.title">
                                                    </form-input>

                                                    <form-input
                                                            type="colorPicker"
                                                            label="Background color"
                                                            item="background_color"
                                                            :model="theme.components2.categories.header.title">
                                                    </form-input>

                                                    <form-input
                                                            type="colorPicker"
                                                            label="Text Color"
                                                            item="color"
                                                            :model="theme.components2.categories.header.title">
                                                    </form-input>

                                                    <form-input
                                                            type="horizontalAlignSelect"
                                                            label="Horizontal align"
                                                            item="horizontal_position"
                                                            :model="theme.components2.categories.header.title">
                                                    </form-input>

                                                    <form-input
                                                            type="verticalAlignSelect"
                                                            label="Vertical align"
                                                            item="vertical_position"
                                                            :model="theme.components2.categories.header.title">
                                                    </form-input>

                                                </panel>

                                            </accordion>

                                        </tab>
                                        <!-- tab Navbar -->

                                        <tab header="Items">
                                            <accordion :one-at-atime="true" type="info">

                                                <panel header="Title" is-open type="primary">

                                                    <form-input
                                                            type="yesNoSelect"
                                                            label="Title visible"
                                                            item="visible"
                                                            :model="theme.components2.items.title">
                                                    </form-input>

                                                    <form-input
                                                            type="fontFamilySelect"
                                                            label="Font family"
                                                            item="font_family"
                                                            :model="theme.components2.items.title">
                                                    </form-input>

                                                    <form-input
                                                            type="textInput"
                                                            label="Google font"
                                                            placeholder="Link of a google font"
                                                            item="font_family_web"
                                                            :model="theme.components2.items.title">
                                                    </form-input>

                                                    <form-input
                                                            type="textInput"
                                                            label="Google font name"
                                                            placeholder="Name of the google font..."
                                                            item="font_family_web_name"
                                                            :model="theme.components2.items.title">
                                                    </form-input>

                                                    <small>(* A filled in google font has priority over the normal font
                                                        family dropdown above)
                                                    </small>

                                                    <form-input
                                                            type="numberInput"
                                                            label="Font size"
                                                            addonLabel="pixels"
                                                            item="font_size"
                                                            :model="theme.components2.items.title">
                                                    </form-input>

                                                    <form-input
                                                            type="colorPicker"
                                                            label="Text Color"
                                                            item="color"
                                                            :model="theme.components2.items.title">
                                                    </form-input>

                                                    <div style="clear:both;"></div>
                                                    <small style="float:right">
                                                        <a href="http://www.cssportal.com/css3-text-shadow-generator/"
                                                           target="_blank">open shadow generator/helper</a>
                                                    </small>
                                                    <div style="clear:both;"></div>

                                                    <form-input
                                                            type="numberInput"
                                                            label="Text shadow horizontal position"
                                                            addonLabel="pixels"
                                                            item="text_shadow_h"
                                                            :model="theme.components2.items.title">
                                                    </form-input>

                                                    <form-input
                                                            type="numberInput"
                                                            label="Text shadow vertical position"
                                                            addonLabel="pixels"
                                                            item="text_shadow_v"
                                                            :model="theme.components2.items.title">
                                                    </form-input>

                                                    <form-input
                                                            type="numberInput"
                                                            label="Text shadow blur/spread"
                                                            addonLabel="pixels"
                                                            item="text_shadow_blur"
                                                            :model="theme.components2.items.title">
                                                    </form-input>

                                                    <form-input
                                                            type="colorPicker"
                                                            label="Text shadow color"
                                                            item="text_shadow_color"
                                                            :model="theme.components2.items.title">
                                                    </form-input>

                                                    <form-input
                                                            type="horizontalAlignSelect"
                                                            label="Horizontal align"
                                                            item="horizontal_position"
                                                            :model="theme.components2.items.title">
                                                    </form-input>

                                                    <form-input
                                                            type="verticalAlignSelect"
                                                            label="Vertical align"
                                                            item="vertical_position"
                                                            :model="theme.components2.items.title">
                                                    </form-input>

                                                </panel>

                                                <panel header="Background">

                                                    <form-input
                                                            type="numberInput"
                                                            label="Border radius"
                                                            addonLabel="pixels"
                                                            item="border_radius"
                                                            :model="theme.components2.items.background">
                                                    </form-input>

                                                    <form-input
                                                            type="numberInput"
                                                            label="Border size"
                                                            addonLabel="pixels"
                                                            item="border_size"
                                                            :model="theme.components2.items.background">
                                                    </form-input>

                                                    <form-input
                                                            type="colorPicker"
                                                            label="Border color"
                                                            item="border_color"
                                                            :model="theme.components2.items.background">
                                                    </form-input>

                                                    <div style="clear:both;"></div>
                                                    <small style="float:right">
                                                        <a href="http://www.cssportal.com/css3-text-shadow-generator/"
                                                           target="_blank">open shadow generator/helper</a>
                                                    </small>
                                                    <div style="clear:both;"></div>

                                                    <form-input
                                                            type="numberInput"
                                                            label="Shadow horizontal position"
                                                            addonLabel="pixels"
                                                            item="text_shadow_h"
                                                            :model="theme.components2.items.background">
                                                    </form-input>

                                                    <form-input
                                                            type="numberInput"
                                                            label="Shadow vertical position"
                                                            addonLabel="pixels"
                                                            item="text_shadow_v"
                                                            :model="theme.components2.items.background">
                                                    </form-input>

                                                    <form-input
                                                            type="numberInput"
                                                            label="Shadow blur/spread"
                                                            addonLabel="pixels"
                                                            item="text_shadow_blur"
                                                            :model="theme.components2.items.background">
                                                    </form-input>

                                                    <form-input
                                                            type="colorPicker"
                                                            label="Shadow color"
                                                            item="text_shadow_color"
                                                            :model="theme.components2.items.background">
                                                    </form-input>

                                                </panel>

                                            </accordion>
                                        </tab>


                                        <tab header="Detail page">

                                            <accordion :one-at-atime="true" type="info">

                                                <panel header="Title" is-open type="primary">

                                                    <form-input
                                                            type="fontFamilySelect"
                                                            label="Font family"
                                                            item="font_family"
                                                            :model="theme.components2.item_detail">
                                                    </form-input>

                                                    <form-input
                                                            type="textInput"
                                                            label="Google font url"
                                                            placeholder="Link of the google font..."
                                                            item="font_family_web"
                                                            :model="theme.components2.item_detail">
                                                    </form-input>

                                                    <form-input
                                                            type="textInput"
                                                            label="Google font name"
                                                            placeholder="Name of the google font..."
                                                            item="font_family_web_name"
                                                            :model="theme.components2.item_detail">
                                                    </form-input>

                                                    <small>(* A filled in google font has priority over the normal font
                                                        family dropdown above)
                                                    </small>

                                                    <form-input
                                                            type="numberInput"
                                                            label="Font size"
                                                            addonLabel="pixels"
                                                            item="font_size"
                                                            :model="theme.components2.item_detail">
                                                    </form-input>

                                                    <form-input
                                                            type="colorPicker"
                                                            label="Text Color"
                                                            item="color"
                                                            :model="theme.components2.item_detail">
                                                    </form-input>

                                                    <form-input
                                                            type="colorPicker"
                                                            label="Background color"
                                                            item="background_color"
                                                            :model="theme.components2.item_detail">
                                                    </form-input>

                                                    <div style="clear:both;"></div>
                                                    <small style="float:right">
                                                        <a href="http://www.cssportal.com/css3-text-shadow-generator/"
                                                           target="_blank">open shadow generator/helper</a>
                                                    </small>
                                                    <div style="clear:both;"></div>

                                                    <form-input
                                                            type="numberInput"
                                                            label="Text shadow horizontal position"
                                                            addonLabel="pixels"
                                                            item="text_shadow_h"
                                                            :model="theme.components2.item_detail">
                                                    </form-input>

                                                    <form-input
                                                            type="numberInput"
                                                            label="Text shadow vertical position"
                                                            addonLabel="pixels"
                                                            item="text_shadow_v"
                                                            :model="theme.components2.item_detail">
                                                    </form-input>

                                                    <form-input
                                                            type="numberInput"
                                                            label="Text shadow blur/spread"
                                                            addonLabel="pixels"
                                                            item="text_shadow_blur"
                                                            :model="theme.components2.item_detail">
                                                    </form-input>

                                                    <form-input
                                                            type="colorPicker"
                                                            label="Text shadow color"
                                                            item="text_shadow_color"
                                                            :model="theme.components2.item_detail">
                                                    </form-input>

                                                </panel>

                                            </accordion>

                                        </tab>
                                        <!-- Header -->

                                    </tabs>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <hr/>
                                </div>
                            </div>
                            <!-- hr -->

                        </template>
                        <!-- hybrideThemeIsSelected -->

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Custom CSS</label>

                            <div class="col-sm-10">
                                <textarea class="form-control" rows="10" v-model="custom_css"></textarea>
                            </div>
                        </div>

                    </template>


                    <div class="form-group margin_top_40">
                        <div class="col-sm-offset-2 col-sm-10 text-right">

                            <button class="btn btn-success min_width_100"
                                    @click="updateTheme(true)"
                                    :class="helpers.spinner.saveAndReturn || helpers.spinner.save ? 'disabled' : ''">
                                <span v-show="!helpers.spinner.saveAndReturn">Save & return</span>
                                <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw bttn_spinner"
                                   v-show="helpers.spinner.saveAndReturn"></i>
                            </button>

                            <button class="btn btn-success min_width_100"
                                    @click="updateTheme()"
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
    import {tabs, tab, tabGroup, tabset, modal, accordion, panel, input, select} from 'vue-strap';
    import {Chrome} from 'vue-color'
    import _ from 'lodash';
    import Dropzone from 'vue2-dropzone';
    import FormInput from './FormInput.vue'

    export default {

        components: {
            tabs, tab, tabGroup, tabset, accordion, panel, Dropzone, vSelect2: select
        },

        props: {
            portal: {},
            themes_: {}
        },

        data() {
            return {

                token: Laravel.csrfToken,

                helpers: {
                    activeTab: 0,
                    activeTab2: 0,
                    spinner: {
                        save: false,
                        saveAndReturn: false
                    },
                    showColorPickers: {}
                },

                themes: {
                    selected: {
                        id: ''
                    },
                    options: []
                },

                custom_css: '',

                theme: {

                    components2: {
                        global: {
                            style: {
                                font_family: 'Use parent font',
                                font_family_web: '',
                                font_family_web_name: ''
                            }
                        },
                        content_type: {
                            header: {
                                header_visible: 'yes',
                                title: {
                                    font_family: 'Use parent font',
                                    font_family_web: '',
                                    font_family_web_name: '',
                                    horizontal_position: 'center',
                                    vertical_position: 'middle',
                                    font_size: 32,
                                    background_color: {hex: ""},
                                    color: {hex: ""}
                                },
                                background: {},
                                more: {
                                    font_family: 'Use parent font',
                                    font_family_web: '',
                                    font_family_web_name: '',
                                    font_size: 20,
                                    background_color: {hex: ""},
                                    color: {hex: "#fff"}
                                }
                            }
                        },
                        categories: {
                            visible: 'yes',
                            header: {
                                title: {
                                    font_family: 'Use parent font',
                                    font_family_web: '',
                                    font_family_web_name: '',
                                    horizontal_position: 'center',
                                    vertical_position: 'middle',
                                    font_size: 32,
                                    background_color: {hex: ""},
                                    color: {hex: ""}
                                }
                            },
                        },
                        items: {
                            title: {
                                visible: 'yes',
                                font_family: 'Use parent font',
                                font_family_web: '',
                                font_family_web_name: '',
                                horizontal_position: 'center',
                                vertical_position: 'middle',
                                font_size: 16,
                                color: {hex: "#fff"},
                                text_shadow_h: 1,
                                text_shadow_v: 1,
                                text_shadow_blur: 4,
                                text_shadow_color: {hex: "#000"}
                            },
                            background: {
                                text_shadow_h: 0,
                                text_shadow_v: 0,
                                text_shadow_blur: 0,
                                text_shadow_color: {hex: "#000"},
                                border_size: 0,
                                border_color: {hex: "#000"},
                                border_radius: 0
                            }
                        },

                        item_detail: {
                            font_family: 'Use parent font',
                            font_family_web: '',
                            font_family_web_name: '',
                            font_size: 33,
                            color: {hex: "#fff"},
                            background_color: {hex: "#000"},
                            text_shadow_h: 0,
                            text_shadow_v: 0,
                            text_shadow_blur: 0,
                            text_shadow_color: {hex: "#000"}
                        }
                    },

                    components: {

                        header: {
                            content: {
                                image: ''
                            },
                            style: {
                                text_align: 'center',
                                background_color: {hex: "#333333"},
                                color: {hex: "#fff"},
                                font_size: 28,
                                font_weight: 'lighter',
                                border_bottom_size: 0,
                                border_color: {hex: ""},
                                height: 67
                            }
                        },

                        navbar: {
                            content: {
                                title: '',
                                image: ''
                            },
                            style: {
                                background_color: {hex: "#00a2e4"},
                                color: {hex: "#fff"},
                                font_size: 14,
                                font_weight: 'lighter',
                                border_bottom_size: 3,
                                border_color: {hex: "#00a2e4"},
                                height: 70,
                                menu_float: 'right',
                                brand_color: {hex: "#fff"},
                                brand_text_align: 'left',
                                brand_font_size: 26,
                                brand_font_weight: 'bold'
                            }
                        },

                        body: {
                            style: {
                                background_color: {hex: '#e0edf6'}
                            }
                        },

                        center: {
                            style: {
                                background_color: {hex: '#fff'},
                                border_left_right_size: 0,
                                border_color: {hex: ""},
                                button_font_size: 14,
                                button_color: {hex: '#fff'},
                                button_background_color: {hex: '#00a2e4'},
                                button_border_color: {hex: ""},
                                button_border_size: 0,
                                content_width: 1024,
                                content_color: {hex: '#000000'},
                                content_primary_color: {hex: '#1cdd6e'},
                                content_secondary_color: {hex: '#b0b0b0'}
                            }
                        },

                        footer: {
                            content: {
                                text: '',
                                image: ''
                            },
                            style: {
                                text_align: 'center',
                                background_color: {hex: '#333333'},
                                color: {hex: '#fff'},
                                font_size: 14,
                                font_weight: 'normal',
                                border_top_size: 0,
                                border_color: {hex: ""},
                                height: 50
                            }
                        },
                    }
                }
            }
        },

        mounted() {
            this.fillTheme();
        },

        computed: {
            hybrideThemeIsSelected() {
                var me = this;

                if (_.findIndex(this.themes.options, function (option) {
                    return option.id == me.themes.selected.id;
                }) >= 0) {

                    var idx = _.findIndex(this.themes.options, function (option) {
                        return option.id == me.themes.selected.id;
                    });

                    if (me.themes.options[idx].theme_name == 'video_theme_2') {
                        return true;
                    }
                    else {
                        return false;
                    }
                }
                else {
                    return false;
                }
            },
            navbarUploadRoute() {
                return '/admin/api/portal-theme/navbar/' + this.portal.id + '/upload';
            },
            footerUploadRoute() {
                return '/admin/api/portal-theme/footer/' + this.portal.id + '/upload'
            }
        },

        methods: {

            fillTheme() {
                this.themes.selected.id = this.portal.content_portal_theme_id;
                this.themes.options = this.themes_;

                if (this.portal.custom_css) this.custom_css = this.portal.custom_css;
                if (this.portal.config) Object.assign(this.theme, (JSON.parse(this.portal.config)));
                if (this.portal.local_content_types.length > 0) this.fillContentTypeBackgroundImages();
            },

            fillContentTypeBackgroundImages() {
                var me = this;
                var _config = this.portal.config ? JSON.parse(this.portal.config) : false;
                var myBackgrounds = {};

                // create background objects for each content type added to this portal
                this.portal.local_content_types.forEach((local_content_type) => {

                    // check if we allready have saved a contenttypes configs earlier which can now be used
                    if (_config && _config.components2 && Object.keys(_config.components2.content_type.header.background).includes(String(local_content_type.id))) {

                        myBackgrounds[local_content_type.id] = {
                            id: _config.components2.content_type.header.background[local_content_type.id].id,
                            name: _config.components2.content_type.header.background[local_content_type.id].name,
                            background_image_opacity: _config.components2.content_type.header.background[local_content_type.id].background_image_opacity,
                            background_image: _config.components2.content_type.header.background[local_content_type.id].background_image,
                            background_color: _config.components2.content_type.header.background[local_content_type.id].background_color
                        }
                    }
                    // else create fresh one
                    else {
                        myBackgrounds[local_content_type.id] = {
                            id: local_content_type.id,
                            name: local_content_type.name,
                            background_image_opacity: 0,
                            background_image: '',
                            background_color: {hex: ""}
                        }
                    }
                });

                this.theme.components2.content_type.header.background = myBackgrounds;
            },

            updateTheme(goBack) {
                console.log(this.theme);

                if (goBack) {
                    this.helpers.spinner.saveAndReturn = true;
                }
                else {
                    this.helpers.spinner.save = true;
                }

                axios.patch('/admin/api/portal-theme/' + this.portal.id, {
                    selectedThemeId: this.themes.selected.id,
                    config: this.theme,
                    custom_css: this.custom_css
                })
                    .then((response) => {
                        this.helpers.spinner.save = false;
                        if (goBack) window.location.href = '/admin/portal';
                    });
            },

            uploadHeaderImage(file, response) {
                this.theme.components.header.content.image = response;
            },

            uploadContentTypeHeaderImage(file, response) {
                this.theme.components2.content_type.header.background[response.id].background_image = response.image;
            },

            uploadNavbarImage(file, response) {
                this.theme.components.navbar.content.image = response;
            },

            uploadFooterImage(file, response) {
                this.theme.components.footer.content.image = response;
            }
        }
    }
</script>
