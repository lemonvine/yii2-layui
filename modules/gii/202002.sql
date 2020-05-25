ALTER TABLE dyzc_business_house ADD COLUMN coowner_number VARCHAR(256) COMMENT '共有产权证编号' AFTER coowner_name;
ALTER TABLE dyzc_business_remark ADD COLUMN other_property VARCHAR(2048) COMMENT '其他资产情况' AFTER loaner_sense;
ALTER TABLE dyzc_business_order ADD COLUMN loaner_name VARCHAR(32) COMMENT '共有产权证编号' AFTER customer_name;
ALTER TABLE dyzc_business_risk ADD COLUMN apply_company VARCHAR(32) COMMENT '申请企业名称' AFTER approval_term;


UPDATE dyzc_business_order SET latest_time =1577808000 WHERE latest_time IS NULL;
DELETE FROM dyzc_system_filetype_scene WHERE filetype_id=42;

UPDATE dyzc_system_status SET display= '已上会' WHERE `status` = 402;

UPDATE dyzc_system_status SET page_path= '/loan/preliminary/create' WHERE `status` = 101;
UPDATE dyzc_system_status SET page_path= '/loan/preliminary/checkup' WHERE `status` = 102;
UPDATE dyzc_system_status SET page_path= '/loan/preliminary/downto' WHERE `status` = 201;
UPDATE dyzc_system_status SET page_path= '/loan/supplement/interview' WHERE `status` = 301;
UPDATE dyzc_system_status SET page_path= '/loan/supplement/reviews' WHERE `status` = 351;
-- UPDATE dyzc_system_status SET page_path= '/loan/supplement/interviews' WHERE `status` = 501;
UPDATE dyzc_system_status SET page_path= '' WHERE `status` = ;
UPDATE dyzc_system_status SET page_path= '' WHERE `status` = ;

