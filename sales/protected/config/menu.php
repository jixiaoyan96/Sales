<?php

return array(
	'Personal'=>array(
		'access'=>'T',
		'items'=>array(
			'Sales order'=>array(
				'access'=>'T01',
				'url'=>'/sales/index',
			),
			'Sales visit'=>array(
				'access'=>'T02',
				'url'=>'/visit/index',
			),
			'Ciustomer Enqury'=>array(
				'access'=>'T03',
				'url'=>'/five/index',
			),
			'Edit Type'=>array(
						'access'=>'T04',
						'url'=>'/choice/index',
				),
		),
	),

	'Sales Admin'=>array(
		'access'=>'TB',
		'items'=>array(
			'Staff list'=>array(
				'access'=>'TB01',
				'url'=>'/staffs/index',
			),
		),
	),
);
