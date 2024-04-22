<?php

return [
    'leave_status' => [
        'approved',
        'rejected',
        'pending'
    ],

    'approved_for_type' => [
        1 => 'days with pay',
        2 => 'days without pay',
        3 => 'others',
    ],

    'leave_type' => [
        [
            'name' => 'Vacation Leave',
            'description' => 'It shall be filed five (5) days in advance, whenever possible, of the effective date of such leave.  Vacation leave within in the Philippines or abroad shall be indicated in the form for purposes of securing travel authority and completing clearance from money and work accountabilities.',
            'date_period' => null,
            'acronym' => 'VL',
        ],
        [
            'name' => 'Mandatory/Forced Leave',
            'description' => 'Annual five-day vacation leave shall be forfeited if not taken during the year.  In case the scheduled leave has been cancelled in the exigency of the service by the head of agency, it shall no longer be deducted from the accumulated vacation leave.  Availment of one (1) day or more Vacation Leave (VL) shall be considered for complying the mandatory/forced leave subject to the conditions under Section 25, Rule XVI of the Omnibus Rules Implementing E.O. No. 292.',
            'date_period' => null,
            'acronym' => 'MFL',
        ],
        [
            'name' => 'Sick Leave',
            'description' => "•	It shall be filed immediately upon employee's return from such leave.  
                •	If filed in advance or exceeding five (5) days, application shall be accompanied by a medical certificate.  In case medical consultation was not availed of, an affidavit should be executed by an applicant.",
            'date_period' => null,
            'acronym' => 'SL',
        ],
        [
            'name' => 'Maternity Leave',
            'description' => "•	Proof of pregnancy e.g. ultrasound, doctor’s certificate on the expected date of delivery
                •	Accomplished Notice of Allocation of Maternity Leave Credits (CS Form No. 6a), if needed
                •	Seconded female employees shall enjoy maternity leave with full pay in the recipient agency.",
            'date_period' => "105 days",
            'acronym' => 'ML',
        ],
        [
            'name' => 'Paternity Leave',
            'description' => "Proof of child’s delivery e.g. birth certificate, medical certificate and marriage contract",
            'date_period' => "7 days",
            'acronym' => 'PL',
        ],
        [
            'name' => 'Special Privilege Leave',
            'description' => "It shall be filed/approved for at least one (1) week prior to availment, except on emergency cases.  Special privilege leave within the Philippines or abroad shall be indicated in the form for purposes of securing travel authority and completing clearance from money and work accountabilities.",
            'date_period' => "3 days",
            'acronym' => 'SPLV',
        ],
        [
            'name' => 'Solo Parent Leave',
            'description' => "It shall be filed in advance or whenever possible five (5) days before going on such leave with updated Solo Parent Identification Card.",
            'date_period' => "7 days",
            'acronym' => 'SPL',
        ],
        [
            'name' => 'Study Leave',
            'description' => "•	Shall meet the agency’s internal requirements, if any;
                •	Contract between the agency head or authorized representative and the employee concerned. ",
            'date_period' => "up to 6 months",
            'acronym' => 'STL',
        ],
        [
            'name' => 'VAWC Leave',
            'description' => "•	It shall be filed in advance or immediately upon the woman employee’s return from such leave.  
                •	It shall be accompanied by any of the following supporting documents:
                a.	Barangay Protection Order (BPO) obtained from the barangay;
                b.	Temporary/Permanent Protection Order (TPO/PPO) obtained from the court;
                c.  If the protection order is not yet issued by the barangay or the court, a certification issued by the Punong Barangay/Kagawad or Prosecutor or the Clerk of Court that the application for the BPO, TPO or PPO has been filed with the said office shall be sufficient to support the application for the ten-day leave; or
                d.	In the absence of the BPO/TPO/PPO or the certification, a police report specifying the details of the occurrence of violence on the victim and a medical certificate may be considered, at the discretion of the immediate supervisor of the woman employee concerned.",
            'date_period' => "10 days",
            'acronym' => 'VAWCL',
        ],
        [
            'name' => 'Rehabilitation Leave',
            'description' => "•	Application shall be made within one (1) week from the time of the accident except when a longer period is warranted.  
                •	Letter request supported by relevant reports such as the police report, if any, 
                •	Medical certificate on the nature of the injuries, the course of treatment involved, and the need to undergo rest, recuperation, and rehabilitation, as the case may be.
                •	Written concurrence of a government physician should be obtained relative to the recommendation for rehabilitation if the attending physician is a private practitioner, particularly on the duration of the period of rehabilitation.",
            'date_period' => "up to 6 months",
            'acronym' => 'RL',
        ],
        [
            'name' => 'Special Leave Benefits for Women',
            'description' => "•	The application may be filed in advance, that is, at least five (5) days prior to the scheduled date of the gynecological surgery that will be undergone by the employee.  In case of emergency, the application for special leave shall be filed immediately upon employee’s return but during confinement the agency shall be notified of said surgery.
                •	The application shall be accompanied by a medical certificate filled out by the proper medical authorities, e.g. the attending surgeon accompanied by a clinical summary reflecting the gynecological disorder which shall be addressed or was addressed by the said surgery; the histopathological report; the operative technique used for the surgery; the duration of the surgery including the peri-operative period (period of confinement around surgery); as well as the employees estimated period of recuperation for the same.",
            'date_period' => "up to 2 months",
            'acronym' => 'SLBW',
        ],
        [
            'name' => 'Special Emergency (Calamity) Leave',
            'description' => "•	The special emergency leave can be applied for a maximum of five (5) straight working days or staggered basis within thirty (30) days from the actual occurrence of the natural calamity/disaster. Said privilege shall be enjoyed once a year, not in every instance of calamity or disaster.
                •	The head of office shall take full responsibility for the grant of special emergency leave and verification of the employee’s eligibility to be granted thereof.  Said verification shall include: validation of place of residence based on latest available records of the affected employee; verification that the place of residence is covered in the declaration of calamity area by the proper government agency; and such other proofs as may be necessary.",
            'date_period' => "up to 5 days",
            'acronym' => 'SECL',
        ],
        [
            'name' => 'Monetization of Leave Credits',
            'description' => "Application for monetization of fifty percent (50%) or more of the accumulated leave credits shall be accompanied by letter request to the head of the agency stating the valid and justifiable reasons.",
            'date_period' => null,
            'acronym' => 'MLC',
        ],
        [
            'name' => 'Terminal Leave',
            'description' => "Proof of employee’s resignation or retirement or separation from the service.  ",
            'date_period' => null,
            'acronym' => 'TL',
        ],
        [
            'name' => 'Adoption Leave',
            'description' => "Application for adoption leave shall be filed with an authenticated copy of the Pre-Adoptive Placement Authority issued by the Department of Social Welfare and Development (DSWD).",
            'date_period' => null,
            'acronym' => 'AL',
        ]
    ]
];