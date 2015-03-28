var globalConfig = {
  api: {
    urls: {
      get_organizations: "{{ path('community_organization_post') }}",

      get_persons: "{{ path('asre_community_persons_post') }}",
      get_locations: "{{ path('content_event_locations_post') }}",

      get_topics: "{{ path('asre_content_topics_post') }}",
      login: "{{ path('login_check', {_format: 'json'}) }}",
      logout: "{{ path('logout') }}",
      registration: "{{ path('security_signup') }}",
      confirm: "{{ path('security_confirm') }}",
      changepwd: "{{ path('security_changepwd') }}",
      reset_pwd_request: "{{ path('asre_community_organizations_') }}",
      reset_pwd: "{{ path('asre_security_resetpwd') }}",
      socialnetworks: [
        {
          name: "{{ owner }}",
          urls: {
            login: "{{ hwi_oauth_login_url(owner) }}",
            enrich: "{{ path('asre_enrich_account', { 'socialService': owner }) }}"
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
