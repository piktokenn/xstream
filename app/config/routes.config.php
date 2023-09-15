<?php 

// General
App::addRoute("GET|POST", "/",															"Main");
App::addRoute("GET|POST", '/404?/?',													"Noting");
App::addRoute("GET|POST", "/ajax/[*:ajax]/[*:action]?/?",								"Ajax"); 
App::addRoute("GET|POST", "/api/[*:api]/[*:action]?/?",									"Api");
App::addRoute("GET|POST", "/modal/[*:modal]?/?",										"Modal"); 
App::addRoute("GET|POST", "/tab/[*:tab]?/?",											"Tab"); 
App::addRoute("GET|POST", "/comments?/?",												"Comments");
App::addRoute("GET|POST", '/'.App::translate('search').'/[*:q]?/?',						"Search");
App::addRoute("GET|POST", '/'.App::translate('login').'?/?',							"Login"); 
App::addRoute("GET|POST", '/'.App::translate('register').'?/?',							"Register"); 
App::addRoute("GET|POST", '/'.App::translate('reset-password').'?/?',					"Reset"); 
App::addRoute("GET|POST", '/'.App::translate('recovery').'/[*:hash]?/?',				"Recovery"); 
App::addRoute("GET|POST", '/'.App::translate('tag').'/[*:q]?/?',						"Tag"); 
App::addRoute("GET|POST", '/'.App::translate('explore').'?/?',							"Explore");
App::addRoute("GET|POST", '/'.App::translate('explore').'/[*:genre]?/?',				"Explore");
App::addRoute("GET|POST", '/'.App::translate('movies').'?/?',							"Movies"); 
App::addRoute("GET|POST", '/'.App::translate('movie').'/[*:self]/[*:tab]?/?',			"Movie"); 
App::addRoute("GET|POST", '/'.App::translate('movie').'/[*:self]?/?',					"Movie"); 
App::addRoute("GET|POST", '/'.App::translate('serie').'/[*:self]-[i:season]-'.App::translate('season').'-[i:episode]-'.App::translate('episode').'/[*:tab]?/?',	"Episode");  
App::addRoute("GET|POST", '/'.App::translate('serie').'/[*:self]-[i:season]-'.App::translate('season').'-[i:episode]-'.App::translate('episode').'?/?',	"Episode");  
App::addRoute("GET|POST", '/'.App::translate('series').'?/?',							"Series"); 
App::addRoute("GET|POST", '/'.App::translate('serie').'/[*:self]/[*:tab]?/?',			"Serie"); 
App::addRoute("GET|POST", '/'.App::translate('serie').'/[*:self]?/?',					"Serie"); 
App::addRoute("GET|POST", '/'.App::translate('top-imdb').'?/?',							"Topimdb");
App::addRoute("GET|POST", '/'.App::translate('platforms').'?/?',						"Platforms"); 
App::addRoute("GET|POST", '/'.App::translate('platform').'/[*:self]-[i:id]?/?',			"Platform"); 
App::addRoute("GET|POST", '/'.App::translate('community').'/[*:sort]?/?',				"Community");
App::addRoute("GET|POST", '/'.App::translate('thread').'/[*:self]-[i:id]?/?',			"Thread"); 
App::addRoute("GET|POST", '/'.App::translate('request').'?/?',							"Request");
App::addRoute("GET|POST", '/'.App::translate('peoples').'?/?',							"Peoples"); 
App::addRoute("GET|POST", '/'.App::translate('people').'/[*:self]-[i:id]?/?',			"People"); 
App::addRoute("GET|POST", '/'.App::translate('user').'/[*:username]/[*:tab]?/?',		"Profile"); 
App::addRoute("GET|POST", '/'.App::translate('collection').'/[*:self]-[i:id]?/?',		"Collection"); 
App::addRoute("GET|POST", '/'.App::translate('page').'/[*:self]?/?',					"Page"); 
App::addRoute("GET|POST", '/logout?/?',													"Logout");  

// Dashboard 
App::addRoute("GET|POST", "/dashboard?/?",												["dashboard","Main"]);
App::addRoute("GET|POST", "/dashboard/settings?/?",										["dashboard","Settings"]);
App::addRoute("GET|POST", "/dashboard/notifications?/?",								["dashboard","Notifications"]);

// Admin 
App::addRoute("GET|POST", "/admin/modal/[*:modal]?/?",									["admin","Modal"]);
App::addRoute("GET|POST", "/admin/ajax/[*:ajax]/[*:action]/?/?",						["admin","Ajax"]);
App::addRoute("GET|POST", "/admin/delete/[*:page]/[i:id]/?/?",							["admin","Delete"]);
App::addRoute("GET|POST", "/admin/ajax/[*:ajax]/?/?",									["admin","Ajax"]);
App::addRoute("GET|POST", "/admin?/?",													["admin","Main"]);

App::addRoute("GET|POST", "/admin/movie/[i:id]?/?",										["admin","Movie"]);
App::addRoute("GET|POST", "/admin/movies?/?",											["admin","Movies"]);

App::addRoute("GET|POST", "/admin/serie/[i:id]?/?",										["admin","Serie"]);
App::addRoute("GET|POST", "/admin/series?/?",											["admin","Series"]);

App::addRoute("GET|POST", "/admin/episode/[i:id]?/?",									["admin","Episode"]);
App::addRoute("GET|POST", "/admin/episodes?/?",											["admin","Episodes"]);

App::addRoute("GET|POST", "/admin/people/[i:id]?/?",									["admin","People"]);
App::addRoute("GET|POST", "/admin/peoples?/?",											["admin","Peoples"]);

App::addRoute("GET|POST", "/admin/genre/[i:id]?/?",										["admin","Genre"]);
App::addRoute("GET|POST", "/admin/genres?/?",											["admin","Genres"]);

App::addRoute("GET|POST", "/admin/platform/[i:id]?/?",									["admin","Platform"]);
App::addRoute("GET|POST", "/admin/platforms?/?",										["admin","Platforms"]);

App::addRoute("GET|POST", "/admin/option/[i:id]?/?",									["admin","Option"]);
App::addRoute("GET|POST", "/admin/options?/?",											["admin","Options"]);

App::addRoute("GET|POST", "/admin/user/[i:id]?/?",										["admin","User"]);
App::addRoute("GET|POST", "/admin/users?/?",											["admin","Users"]);

App::addRoute("GET|POST", "/admin/collection/[i:id]?/?",								["admin","Collection"]);
App::addRoute("GET|POST", "/admin/collections?/?",										["admin","Collections"]);

App::addRoute("GET|POST", "/admin/tmdb?/?",												["admin","Tmdb"]);
App::addRoute("GET|POST", "/admin/tools?/?",											["admin","Tools"]);

App::addRoute("GET|POST", "/admin/report/[i:id]?/?",									["admin","Report"]);
App::addRoute("GET|POST", "/admin/reports?/?",											["admin","Reports"]);

App::addRoute("GET|POST", "/admin/thread/[i:id]?/?",									["admin","Thread"]);
App::addRoute("GET|POST", "/admin/community?/?",										["admin","Community"]);

App::addRoute("GET|POST", "/admin/comment/[i:id]?/?",									["admin","Comment"]);
App::addRoute("GET|POST", "/admin/comments?/?",											["admin","Comments"]);

App::addRoute("GET|POST", "/admin/country/[i:id]?/?",									["admin","Country"]);
App::addRoute("GET|POST", "/admin/countries?/?",										["admin","Countries"]);

App::addRoute("GET|POST", "/admin/language/[i:id]?/?",									["admin","Language"]);
App::addRoute("GET|POST", "/admin/languages?/?",										["admin","Languages"]);

App::addRoute("GET|POST", "/admin/ad/[i:id]?/?",										["admin","Ad"]);
App::addRoute("GET|POST", "/admin/ads?/?",												["admin","Ads"]);

App::addRoute("GET|POST", "/admin/page/[i:id]?/?",										["admin","Page"]);
App::addRoute("GET|POST", "/admin/pages?/?",											["admin","Pages"]);

App::addRoute("GET|POST", "/admin/request/[i:id]?/?",									["admin","Request"]);
App::addRoute("GET|POST", "/admin/requests?/?",											["admin","Requests"]);

App::addRoute("GET|POST", "/admin/clear-cache?/?",										["admin","Clear"]);

App::addRoute("GET|POST", "/admin/settings?/?",											["admin","Settings"]);

// Sitemap
App::addRoute("GET", "/sitemap.post_[i:page].xml?/?",			"SitemapPost");
App::addRoute("GET", "/sitemap.episode_[i:page].xml?/?",		"SitemapEpisode");
App::addRoute("GET", "/sitemap.people_[i:page].xml?/?",			"SitemapPeople");
App::addRoute("GET", "/sitemap.genre_[i:page].xml?/?",			"SitemapGenre");
App::addRoute("GET", "/sitemap.collection_[i:page].xml?/?",		"SitemapCollection");
App::addRoute("GET", "/sitemap.thread_[i:page].xml?/?",			"SitemapThread");
App::addRoute("GET", "/sitemap.main.xml?/?",					"SitemapMain");
App::addRoute("GET", "/sitemap.xml?/?", 						"Sitemap"); 