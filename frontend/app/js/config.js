var globalConfig = {

  authentication: {
    shouldLogin: true
  },
  schedule: {
    constants: {
      calendar_start_hour: moment.duration(6, 'hours'),
      calendar_end_hour: moment.duration(21, 'hours'),
      calendar_default_time_event_durantion: moment.duration(15, 'minutes'),
      event_minutes_step: 15 // Same value as calendar_default_time_event_durantion
    }
  },
  language: 'EN'

};


angular.module('asreApp').constant('GLOBAL_CONFIG', $.extend(globalConfig, wsConfig));
