SELECT package.pkg_id, package.pkg_country, availability.avail_start_date, availability.avail_end_date
FROM `availability` INNER JOIN package 
on package.availability_avail_id = availability.avail_id