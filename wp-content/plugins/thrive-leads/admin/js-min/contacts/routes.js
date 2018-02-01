/*! Thrive Leads - The ultimate Lead Capture solution for wordpress - 2018-01-24
* https://thrivethemes.com 
* Copyright (c) 2018 * Thrive Themes */

var ThriveLeads=ThriveLeads||{};jQuery(function(){var a=Backbone.Router.extend({routes:{contacts:"contacts"},contacts:function(){var a=new ThriveLeads.views.Contacts({el:"#tve-contacts"});a.globalSettings=TVE_Page_Data.globalSettings;var b=new ThriveLeads.views.Breadcrumbs({collection:ThriveLeads.objects.BreadcrumbsCollection,el:"#tve-leads-breadcrumbs"});a.render(),b.render(),TVE_Dash.materialize(a.$el)}});ThriveLeads.router=new a,Backbone.history.start({hashChange:!0})});