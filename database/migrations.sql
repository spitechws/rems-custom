ALTER TABLE `tbl_activity` RENAME `activity`;
ALTER TABLE `tbl_admin_user` RENAME `admin_user`;
ALTER TABLE `tbl_admin_user_action` RENAME `admin_user_action`;
ALTER TABLE `tbl_advisor` RENAME `advisor`;
ALTER TABLE `tbl_advisor_action` RENAME `advisor_action`;
ALTER TABLE `tbl_advisor_commission` RENAME `advisor_commission`;
ALTER TABLE `tbl_advisor_dvr` RENAME `advisor_dvr`;
ALTER TABLE `tbl_advisor_payment` RENAME `advisor_payment`;
ALTER TABLE `tbl_advisor_promotion` RENAME `advisor_promotion`;
ALTER TABLE `tbl_award` RENAME `award`;
ALTER TABLE `tbl_complain` RENAME `complain`;
ALTER TABLE `tbl_customer` RENAME `customer`;
ALTER TABLE `tbl_customer_action` RENAME `customer_action`;
ALTER TABLE `tbl_enquiry` RENAME `enquiry`;
ALTER TABLE `tbl_expense` RENAME `expense`;
ALTER TABLE `tbl_expense_category` RENAME `expense_category`;
ALTER TABLE `tbl_expense_sub_category` RENAME `expense_sub_category`;
ALTER TABLE `tbl_project` RENAME `project`;
ALTER TABLE `tbl_project_details` RENAME `project_details`;
ALTER TABLE `tbl_project_property_type_rate` RENAME `project_property_type_rate`;
ALTER TABLE `tbl_property` RENAME `property`;
ALTER TABLE `tbl_property_booking` RENAME `property_booking`;
ALTER TABLE `tbl_property_booking_cancelled` RENAME `property_booking_cancelled`;
ALTER TABLE `tbl_property_booking_deleted` RENAME `property_booking_deleted`;
ALTER TABLE `tbl_property_booking_extra_charge` RENAME `property_booking_extra_charge`;
ALTER TABLE `tbl_property_booking_extra_charge_payment` RENAME `property_booking_extra_charge_payment`;
ALTER TABLE `tbl_property_booking_payments` RENAME `property_booking_payments`;
ALTER TABLE `tbl_property_booking_payments_doc` RENAME `property_booking_payments_doc`;
ALTER TABLE `tbl_property_updates` RENAME `property_updates`;
ALTER TABLE `tbl_setting_advisor_level` RENAME `setting_advisor_level`;
ALTER TABLE `tbl_setting_advisor_level_with_property_type` RENAME `setting_advisor_level_with_property_type`;
ALTER TABLE `tbl_setting_property_type` RENAME `setting_property_type`;
ALTER TABLE `tbl_setting_tds` RENAME `setting_tds`;
ALTER TABLE `tbl_site_settings` RENAME `site_settings`;
ALTER TABLE `tbl_sms_sent` RENAME `sms_sent`;
ALTER TABLE `tbl_spitech_sms_server` RENAME `spitech_sms_server`;
ALTER TABLE `tbl_spitech_user` RENAME `spitech_user`;
ALTER TABLE `tb_advisor_docs` RENAME `advisor_docs`;


-- site settings

UPDATE `site_settings` SET `id` = '1';

ALTER TABLE `site_settings` ADD `website` VARCHAR(100) NOT NULL DEFAULT '' AFTER `site_heading`;
ALTER TABLE `site_settings` CHANGE `website` `site_website` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '';

ALTER TABLE `site_settings`
  DROP `site_icon`,
  DROP `site_logo`,
  DROP `site_url_home`,
  DROP `site_application_url`;
