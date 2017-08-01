CREATE TABLE IF NOT EXISTS user(
	id INT(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
	email VARCHAR(255) NOT NULL UNIQUE,
	password CHAR(118) NOT NULL,
	password_restore CHAR(32) NULL UNIQUE,		
	active BOOLEAN DEFAULT 0 NOT NULL,	
	last_visit DATETIME NULL,	
	create_date DATETIME NOT NULL,
	creator_id INT(10) unsigned NOT NULL,
	last_modify DATETIME NULL,
	last_modifier_id INT(10) unsigned NULL
) ENGINE=MyISAM
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci
AUTO_INCREMENT 1;

INSERT INTO user (email, password, active, create_date, creator_id) VALUES('test@test.com', '$2y$10$GVh1IuwdQQvkBD1Q4XVf3eP.A0TcPYkGFOBwoJllfs0Z5nHHjlFoS', true, NOW(), 0);

CREATE TABLE IF NOT EXISTS customer(
	id INT(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
	email VARCHAR(255) NOT NULL UNIQUE,
	name VARCHAR(64) NULL,
	surname VARCHAR(64) NULL,	
	country_id SMALLINT(5) unsigned NOT NULL,
	city VARCHAR(64) NULL,
	postal_code VARCHAR(12) NULL,
	street VARCHAR(64) NULL,	
	company_reg_id VARCHAR(8) NULL COMMENT 'IČO in format: 12345679',
	tax_id VARCHAR(10) NULL COMMENT 'DIČ in format: 1234567895',
	vat_number VARCHAR(12) NULL COMMENT 'IČ DPH in format: SK1234567895',
	create_date DATETIME NOT NULL,
	creator_id INT(10) unsigned NOT NULL,
	last_modify DATETIME NULL,
	last_modifier_id INT(10) unsigned NULL
) ENGINE=MyISAM
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci
AUTO_INCREMENT 1;

CREATE TABLE IF NOT EXISTS invoice(
	id CHAR(9) NOT NULL PRIMARY KEY COMMENT 'RRMMDDCCC',	
	customer_id INT(10) unsigned NOT NULL,
	name VARCHAR(64) NOT NULL,
	description TEXT NOT NULL,
	price DECIMAL(10,2) unsigned NOT NULL,
	create_date DATETIME NOT NULL,
	creator_id INT(10) unsigned NOT NULL,
	last_modify DATETIME NULL,
	last_modifier_id INT(10) unsigned NULL,
	INDEX customer_id_idx (customer_id)
) ENGINE=MyISAM
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci
AUTO_INCREMENT 1;

CREATE TABLE IF NOT EXISTS country(
	id SMALLINT(5) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(64) NOT NULL UNIQUE,
	region VARCHAR(32) NOT NULL
) ENGINE=MyISAM
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci
AUTO_INCREMENT 1;

/* Country list */
INSERT INTO country (name, region) VALUES('Afghanistan', 'Asia');
INSERT INTO country (name, region) VALUES('Albania', 'Europe');
INSERT INTO country (name, region) VALUES('Algeria', 'Africa');
INSERT INTO country (name, region) VALUES('American Samoa', 'Australasia');
INSERT INTO country (name, region) VALUES('Andorra', 'Europe');
INSERT INTO country (name, region) VALUES('Angola', 'Africa');
INSERT INTO country (name, region) VALUES('Anguilla', 'Caribbean');
INSERT INTO country (name, region) VALUES('Antigua and Barbuda', 'Caribbean');
INSERT INTO country (name, region) VALUES('Argentina', 'South America');
INSERT INTO country (name, region) VALUES('Armenia', 'Europe');
INSERT INTO country (name, region) VALUES('Aruba', 'Caribbean');
INSERT INTO country (name, region) VALUES('Australia', 'Australasia');
INSERT INTO country (name, region) VALUES('Austria', 'Europe');
INSERT INTO country (name, region) VALUES('Azerbaijan', 'Europe');
INSERT INTO country (name, region) VALUES('Bahamas', 'Caribbean');
INSERT INTO country (name, region) VALUES('Bahrain', 'Middle East');
INSERT INTO country (name, region) VALUES('Bangladesh', 'Asia');
INSERT INTO country (name, region) VALUES('Barbados', 'Caribbean');
INSERT INTO country (name, region) VALUES('Belarus', 'Europe');
INSERT INTO country (name, region) VALUES('Belgium', 'Europe');
INSERT INTO country (name, region) VALUES('Belize', 'North America');
INSERT INTO country (name, region) VALUES('Benin', 'Africa');
INSERT INTO country (name, region) VALUES('Bermuda', 'Caribbean');
INSERT INTO country (name, region) VALUES('Bhutan', 'Asia');
INSERT INTO country (name, region) VALUES('Bolivia', 'South America');
INSERT INTO country (name, region) VALUES('Bonaire', 'Caribbean');
INSERT INTO country (name, region) VALUES('Bosnia-Herzegovina', 'Europe');
INSERT INTO country (name, region) VALUES('Botswana', 'Africa');
INSERT INTO country (name, region) VALUES('Bouvet', 'Island	Africa');
INSERT INTO country (name, region) VALUES('Brazil', 'South America');
INSERT INTO country (name, region) VALUES('Brunei', 'Asia');
INSERT INTO country (name, region) VALUES('Bulgaria', 'Europe');
INSERT INTO country (name, region) VALUES('Burkina', 'Faso	Africa');
INSERT INTO country (name, region) VALUES('Burundi', 'Africa');
INSERT INTO country (name, region) VALUES('Cambodia', 'Asia');
INSERT INTO country (name, region) VALUES('Cameroon', 'Africa');
INSERT INTO country (name, region) VALUES('Canada', 'North America');
INSERT INTO country (name, region) VALUES('Cape', 'Verde	Africa');
INSERT INTO country (name, region) VALUES('Cayman', 'Islands	Caribbean');
INSERT INTO country (name, region) VALUES('Central', 'African Republic	Africa');
INSERT INTO country (name, region) VALUES('Chad', 'Africa');
INSERT INTO country (name, region) VALUES('Chile', 'South America');
INSERT INTO country (name, region) VALUES('China', 'Asia');
INSERT INTO country (name, region) VALUES('Christmas', 'Island	Australasia');
INSERT INTO country (name, region) VALUES('Cocos', '(Keeling) Islands	Australasia');
INSERT INTO country (name, region) VALUES('Colombia', 'South America');
INSERT INTO country (name, region) VALUES('Comoros', 'Africa');
INSERT INTO country (name, region) VALUES('Congo Democratic Republic of the (Zaire)', 'Africa');
INSERT INTO country (name, region) VALUES('Congo Republic of', 'Africa');
INSERT INTO country (name, region) VALUES('Cook', 'Islands	Australasia');
INSERT INTO country (name, region) VALUES('Costa Rica', 'North America');
INSERT INTO country (name, region) VALUES('Croatia', 'Europe');
INSERT INTO country (name, region) VALUES('Cuba', 'Caribbean');
INSERT INTO country (name, region) VALUES('Curacao', 'Caribbean');
INSERT INTO country (name, region) VALUES('Cyprus', 'Europe');
INSERT INTO country (name, region) VALUES('Czech Republic', 'Europe');
INSERT INTO country (name, region) VALUES('Denmark', 'Europe');
INSERT INTO country (name, region) VALUES('Djibouti', 'Africa');
INSERT INTO country (name, region) VALUES('Dominica', 'Caribbean');
INSERT INTO country (name, region) VALUES('Dominican Republic', 'Caribbean');
INSERT INTO country (name, region) VALUES('Ecuador', 'South America');
INSERT INTO country (name, region) VALUES('Egypt', 'Africa');
INSERT INTO country (name, region) VALUES('El Salvador', 'North America');
INSERT INTO country (name, region) VALUES('Equatorial', 'Guinea	Africa');
INSERT INTO country (name, region) VALUES('Eritrea', 'Africa');
INSERT INTO country (name, region) VALUES('Estonia', 'Europe');
INSERT INTO country (name, region) VALUES('Ethiopia', 'Africa');
INSERT INTO country (name, region) VALUES('Falkland Islands', 'South America');
INSERT INTO country (name, region) VALUES('Faroe Islands', 'Europe');
INSERT INTO country (name, region) VALUES('Fiji', 'Australasia');
INSERT INTO country (name, region) VALUES('Finland', 'Europe');
INSERT INTO country (name, region) VALUES('France', 'Europe');
INSERT INTO country (name, region) VALUES('French Guiana', 'South America');
INSERT INTO country (name, region) VALUES('Gabon', 'Africa');
INSERT INTO country (name, region) VALUES('Gambia', 'Africa');
INSERT INTO country (name, region) VALUES('Georgia', 'Europe');
INSERT INTO country (name, region) VALUES('Germany', 'Europe');
INSERT INTO country (name, region) VALUES('Ghana', 'Africa');
INSERT INTO country (name, region) VALUES('Gibraltar', 'Europe');
INSERT INTO country (name, region) VALUES('Greece', 'Europe');
INSERT INTO country (name, region) VALUES('Greenland', 'Europe');
INSERT INTO country (name, region) VALUES('Grenada', 'Caribbean');
INSERT INTO country (name, region) VALUES('Guadeloupe (French)', 'Caribbean');
INSERT INTO country (name, region) VALUES('Guam (USA)', 'Australasia');
INSERT INTO country (name, region) VALUES('Guatemala', 'North America');
INSERT INTO country (name, region) VALUES('Guinea', 'Africa');
INSERT INTO country (name, region) VALUES('Guinea Bissau', 'Africa');
INSERT INTO country (name, region) VALUES('Guyana', 'South America');
INSERT INTO country (name, region) VALUES('Haiti', 'Caribbean');
INSERT INTO country (name, region) VALUES('Holy See', 'Europe');
INSERT INTO country (name, region) VALUES('Honduras', 'North America');
INSERT INTO country (name, region) VALUES('Hong', 'Kong	Asia');
INSERT INTO country (name, region) VALUES('Hungary', 'Europe');
INSERT INTO country (name, region) VALUES('Iceland', 'Europe');
INSERT INTO country (name, region) VALUES('India', 'Asia');
INSERT INTO country (name, region) VALUES('Indonesia', 'Asia');
INSERT INTO country (name, region) VALUES('Iran', 'Middle East');
INSERT INTO country (name, region) VALUES('Iraq', 'Middle East');
INSERT INTO country (name, region) VALUES('Ireland', 'Europe');
INSERT INTO country (name, region) VALUES('Israel', 'Middle East');
INSERT INTO country (name, region) VALUES('Italy', 'Europe');
INSERT INTO country (name, region) VALUES('Ivory Coast (Cote D`Ivoire)', 'Africa');
INSERT INTO country (name, region) VALUES('Jamaica', 'Caribbean');
INSERT INTO country (name, region) VALUES('Japan', 'Asia');
INSERT INTO country (name, region) VALUES('Jordan', 'Middle East');
INSERT INTO country (name, region) VALUES('Kazakhstan', 'Asia');
INSERT INTO country (name, region) VALUES('Kenya', 'Africa');
INSERT INTO country (name, region) VALUES('Kiribati', 'Australasia');
INSERT INTO country (name, region) VALUES('Kosovo', 'Europe');
INSERT INTO country (name, region) VALUES('Kuwait', 'Middle East');
INSERT INTO country (name, region) VALUES('Kyrgyzstan', 'Asia');
INSERT INTO country (name, region) VALUES('Laos', 'Asia');
INSERT INTO country (name, region) VALUES('Latvia', 'Europe');
INSERT INTO country (name, region) VALUES('Lebanon', 'Middle East');
INSERT INTO country (name, region) VALUES('Lesotho', 'Africa');
INSERT INTO country (name, region) VALUES('Liberia', 'Africa');
INSERT INTO country (name, region) VALUES('Libya', 'Africa');
INSERT INTO country (name, region) VALUES('Liechtenstein', 'Europe');
INSERT INTO country (name, region) VALUES('Lithuania', 'Europe');
INSERT INTO country (name, region) VALUES('Luxembourg', 'Europe');
INSERT INTO country (name, region) VALUES('Macau', 'Asia');
INSERT INTO country (name, region) VALUES('Macedonia', 'Europe');
INSERT INTO country (name, region) VALUES('Madagascar', 'Africa');
INSERT INTO country (name, region) VALUES('Malawi', 'Africa');
INSERT INTO country (name, region) VALUES('Malaysia', 'Asia');
INSERT INTO country (name, region) VALUES('Maldives', 'Asia');
INSERT INTO country (name, region) VALUES('Mali', 'Africa');
INSERT INTO country (name, region) VALUES('Malta', 'Europe');
INSERT INTO country (name, region) VALUES('Marshall Islands', 'Australasia');
INSERT INTO country (name, region) VALUES('Martinique (French)', 'Caribbean');
INSERT INTO country (name, region) VALUES('Mauritania', 'Africa');
INSERT INTO country (name, region) VALUES('Mauritius', 'Africa');
INSERT INTO country (name, region) VALUES('Mayotte', 'Africa');
INSERT INTO country (name, region) VALUES('Mexico', 'North America');
INSERT INTO country (name, region) VALUES('Micronesia', 'Australasia');
INSERT INTO country (name, region) VALUES('Moldova', 'Europe');
INSERT INTO country (name, region) VALUES('Monaco', 'Europe');
INSERT INTO country (name, region) VALUES('Mongolia', 'Asia');
INSERT INTO country (name, region) VALUES('Montenegro', 'Europe');
INSERT INTO country (name, region) VALUES('Montserrat', 'Caribbean');
INSERT INTO country (name, region) VALUES('Morocco', 'Africa');
INSERT INTO country (name, region) VALUES('Mozambique', 'Africa');
INSERT INTO country (name, region) VALUES('Myanmar', 'Asia');
INSERT INTO country (name, region) VALUES('Namibia', 'Africa');
INSERT INTO country (name, region) VALUES('Nauru', 'Australasia');
INSERT INTO country (name, region) VALUES('Nepal', 'Asia');
INSERT INTO country (name, region) VALUES('Netherlands', 'Europe');
INSERT INTO country (name, region) VALUES('Netherlands Antilles', 'Caribbean');
INSERT INTO country (name, region) VALUES('New Caledonia (French)', 'Australasia');
INSERT INTO country (name, region) VALUES('New Zealand', 'Australasia');
INSERT INTO country (name, region) VALUES('Nicaragua', 'North America');
INSERT INTO country (name, region) VALUES('Niger', 'Africa');
INSERT INTO country (name, region) VALUES('Nigeria', 'Africa');
INSERT INTO country (name, region) VALUES('Niue', 'Australasia');
INSERT INTO country (name, region) VALUES('Norfolk Island', 'Australasia');
INSERT INTO country (name, region) VALUES('North Korea', 'Asia');
INSERT INTO country (name, region) VALUES('Northern Mariana Islands', 'Asia');
INSERT INTO country (name, region) VALUES('Norway', 'Europe');
INSERT INTO country (name, region) VALUES('Oman', 'Middle East');
INSERT INTO country (name, region) VALUES('Pakistan', 'Asia');
INSERT INTO country (name, region) VALUES('Palau', 'Australasia');
INSERT INTO country (name, region) VALUES('Panama', 'North America');
INSERT INTO country (name, region) VALUES('Papua New Guinea', 'Australasia');
INSERT INTO country (name, region) VALUES('Paraguay', 'South America');
INSERT INTO country (name, region) VALUES('Peru', 'South America');
INSERT INTO country (name, region) VALUES('Philippines', 'Asia');
INSERT INTO country (name, region) VALUES('Pitcairn Island', 'Australasia');
INSERT INTO country (name, region) VALUES('Poland', 'Europe');
INSERT INTO country (name, region) VALUES('Polynesia (French)', 'Australasia');
INSERT INTO country (name, region) VALUES('Portugal', 'Europe');
INSERT INTO country (name, region) VALUES('Puerto Rico', 'Caribbean');
INSERT INTO country (name, region) VALUES('Qatar', 'Middle East');
INSERT INTO country (name, region) VALUES('Reunion', 'Africa');
INSERT INTO country (name, region) VALUES('Romania', 'Europe');
INSERT INTO country (name, region) VALUES('Russia', 'Europe');
INSERT INTO country (name, region) VALUES('Rwanda', 'Africa');
INSERT INTO country (name, region) VALUES('Saint Helena', 'Africa');
INSERT INTO country (name, region) VALUES('Saint Kitts and Nevis', 'Caribbean');
INSERT INTO country (name, region) VALUES('Saint Lucia', 'Caribbean');
INSERT INTO country (name, region) VALUES('Saint Pierre and Miquelon', 'North America');
INSERT INTO country (name, region) VALUES('Saint Vincent and Grenadines', 'Caribbean');
INSERT INTO country (name, region) VALUES('Samoa', 'Australasia');
INSERT INTO country (name, region) VALUES('San Marino', 'Europe');
INSERT INTO country (name, region) VALUES('Sao Tome and Principe', 'Africa');
INSERT INTO country (name, region) VALUES('Saudi Arabia', 'Middle East');
INSERT INTO country (name, region) VALUES('Senegal', 'Africa');
INSERT INTO country (name, region) VALUES('Serbia', 'Europe');
INSERT INTO country (name, region) VALUES('Seychelles', 'Africa');
INSERT INTO country (name, region) VALUES('Sierra Leone', 'Africa');
INSERT INTO country (name, region) VALUES('Singapore', 'Asia');
INSERT INTO country (name, region) VALUES('Sint Maarten', 'Caribbean');
INSERT INTO country (name, region) VALUES('Slovakia', 'Europe');
INSERT INTO country (name, region) VALUES('Slovenia', 'Europe');
INSERT INTO country (name, region) VALUES('Solomon Islands', 'Australasia');
INSERT INTO country (name, region) VALUES('Somalia', 'Africa');
INSERT INTO country (name, region) VALUES('South Africa', 'Africa');
INSERT INTO country (name, region) VALUES('South Georgia and South Sandwich Islands', 'South America');
INSERT INTO country (name, region) VALUES('South Korea', 'Asia');
INSERT INTO country (name, region) VALUES('South Sudan', 'Africa');
INSERT INTO country (name, region) VALUES('Spain', 'Europe');
INSERT INTO country (name, region) VALUES('Sri', 'Lanka	Asia');
INSERT INTO country (name, region) VALUES('Sudan', 'Africa');
INSERT INTO country (name, region) VALUES('Suriname', 'South America');
INSERT INTO country (name, region) VALUES('Svalbard and Jan Mayen Islands', 'Europe');
INSERT INTO country (name, region) VALUES('Swaziland', 'Africa');
INSERT INTO country (name, region) VALUES('Sweden', 'Europe');
INSERT INTO country (name, region) VALUES('Switzerland', 'Europe');
INSERT INTO country (name, region) VALUES('Syria', 'Middle East');
INSERT INTO country (name, region) VALUES('Taiwan', 'Asia');
INSERT INTO country (name, region) VALUES('Tajikistan', 'Asia');
INSERT INTO country (name, region) VALUES('Tanzania', 'Africa');
INSERT INTO country (name, region) VALUES('Thailand', 'Asia');
INSERT INTO country (name, region) VALUES('Timor-Leste (East Timor)', 'Australasia');
INSERT INTO country (name, region) VALUES('Togo', 'Africa');
INSERT INTO country (name, region) VALUES('Tokelau', 'Australasia');
INSERT INTO country (name, region) VALUES('Tonga', 'Australasia');
INSERT INTO country (name, region) VALUES('Trinidad and Tobago', 'Caribbean');
INSERT INTO country (name, region) VALUES('Tunisia', 'Africa');
INSERT INTO country (name, region) VALUES('Turkey', 'Middle East');
INSERT INTO country (name, region) VALUES('Turkmenistan', 'Asia');
INSERT INTO country (name, region) VALUES('Turks and Caicos Islands', 'Caribbean');
INSERT INTO country (name, region) VALUES('Tuvalu', 'Australasia');
INSERT INTO country (name, region) VALUES('Uganda', 'Africa');
INSERT INTO country (name, region) VALUES('Ukraine', 'Europe');
INSERT INTO country (name, region) VALUES('United Arab Emirates', 'Middle East');
INSERT INTO country (name, region) VALUES('United Kingdom', 'Europe');
INSERT INTO country (name, region) VALUES('United States', 'North America');
INSERT INTO country (name, region) VALUES('Uruguay', 'South America');
INSERT INTO country (name, region) VALUES('Uzbekistan', 'Asia');
INSERT INTO country (name, region) VALUES('Vanuatu', 'Australasia');
INSERT INTO country (name, region) VALUES('Venezuela', 'South America');
INSERT INTO country (name, region) VALUES('Vietnam', 'Asia');
INSERT INTO country (name, region) VALUES('Virgin Islands', 'Caribbean');
INSERT INTO country (name, region) VALUES('Wallis and Futuna Islands', 'Australasia');
INSERT INTO country (name, region) VALUES('Yemen', 'Middle East');
INSERT INTO country (name, region) VALUES('Zambia', 'Africa');
INSERT INTO country (name, region) VALUES('Zimbabwe', 'Africa');