<?php

$GLOBALS['MC_LOG'] = array(
    // log level，0x07 = LOG_LEVEL_FATAL|LOG_LEVEL_WARNING|LOG_LEVEL_NOTICE
    // 'intLevel' => 0x1F, // DEBUG
    'intLevel' => 0x1F,
    // log file name, wf: niportal.log.wf
    'strLogFile' => MC_ROOT . '/log/mcphp.log',
    // self log files
    'arrSelfLogFiles' => array(),
    // 0: no limit
    'intMaxFileSize' => 0,
    /**
     * log split config
     *   kind: day/hour/min
     *   interval: number
     */
    'arrSplitFile' => array(
        // per day
        'kind' => 'day',
        'interval' => '1',
    ),
    // log string format: #{KEY}
    'strLogFormat' => '',
);

