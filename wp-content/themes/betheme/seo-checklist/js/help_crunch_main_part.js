(function(w,d){
    w.HelpCrunch=function(){w.HelpCrunch.q.push(arguments)};w.HelpCrunch.q=[];
    function r(){var s=document.createElement('script');s.async=1;s.type='text/javascript';s.src='https://seranking.helpcrunch.com/compiled/sdk.js';(d.body||d.head).appendChild(s);}
    if(w.attachEvent){w.attachEvent('onload',r)}else{w.addEventListener('load',r,false)}
})(window, document);

HelpCrunch('init', 'seranking', helpCrunchParams);
HelpCrunch('showChatWidget');

HelpCrunch('onReady', function() {
    if (document.querySelectorAll('.helpcrunch-status-bar').length) {
        document.querySelector('.footer_contact_support_link').href = "javascript:HelpCrunch('openChat');";
    } 
});