/*! Thrive Clever Widgets 2017-11-29
* http://www.thrivethemes.com 
* Copyright (c) 2017 * Thrive Themes */
var tcw_app=tcw_app||{};!function(){tcw_app.Template=Backbone.Model.extend({defaults:{name:"",description:"",hangers:""},initialize:function(a,b){this.set("hangers",new Backbone.Collection([a.show_widget_options,a.hide_widget_options]))}})}(jQuery);