var globalConfig = {
  api: {
    urls: {
      get_organizations: "{{ path('community_organization_post') }}",

      get_persons: "{{ path('community_persons_post') }}",
      get_locations: "{{ path('content_event_locations_post') }}",

      get_topics: "{{ path('content_topics_post') }}",
      login: "{{ path('login_check', {_format: 'json'}) }}",
      logout: "{{ path('logout') }}",
      registration: "{{ path('security_signup') }}",
      confirm: "{{ path('security_confirm') }}",
      changepwd: "{{ path('security_changepwd') }}",
      reset_pwd_request: "{{ path('security_resetpwdrequest') }}",
      reset_pwd: "{{ path('security_resetpwd') }}",
      socialnetworks: [
        {
          name: "{{ owner }}",
          urls: {
            login: "{{ hwi_oauth_login_url(owner) }}",
            enrich: "{{ path('enrich_account', { 'socialService': owner }) }}"
          },
          can_register: true
        }
      ]
    }
  },
  app: {
    options: {
      shouldLogin: true
    },
  },
  language: 'EN'
};
angular.module('asreApp').value('GLOBAL_CONFIG', globalConfig);
