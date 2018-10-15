<?php

return [
    
    'sms' => [
        'monthlySpendLimit' => env('SNS_SMS_MONTHLY_LIMIT', '1'),
        //'deliveryStatusIAMRole' => env('SNS_SMS_DELIVERY_STATUS_IAM_ROLE'),
        //'deliveryStatusSuccessSamplingRate' => env('SNS_SMS_DELIVERY_STATUS'),
        //'defaultSenderID' => env('SNS_SMS_SENDER', 'AW-MELDOC'),
        'defaultSMSType' => env('SNS_SMS_TYPE', 'Transactional'),
        //'usageReportS3Bucket' => env('SNS_SMS_REPORT_S3')
    ]
];
