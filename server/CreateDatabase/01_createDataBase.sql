create table organizations(
	organization_id int(255) UNSIGNED not null auto_increment primary key,
	name_ja varchar(255) not null unique,
	name_original varchar(255) not null unique
) DEFAULT CHARSET=utf8;
ALTER TABLE organizations ADD INDEX index_name(organization_id);

create table collectors(
	collector_id int(255) UNSIGNED not null auto_increment primary key,
	name_ja varchar(255) not null unique,
	name_original varchar(255) not null unique
) DEFAULT CHARSET=utf8;
ALTER TABLE collectors ADD INDEX index_name(collector_id);

create table documents(
	id int(255) UNSIGNED not null auto_increment primary key,
	document_id int(255) UNSIGNED not null unique,
	organization_id int(255) UNSIGNED not null,
	collection_location_no varchar(255) not null unique,
	project_id varchar(255) not null,
	location_shelf varchar(255) not null,
	location_no int(255) not null,
	p int(255) not null,
	volume varchar(255) not null,
	s_no int(255) not null,
	branch_no varchar(255) not null,
	title_ja varchar(255) not null,
	title_en varchar(255) not null,
	ad int(255) not null,
	collector_id int(255) UNSIGNED not null,
	period varchar(255) not null,
	location varchar(255) not null,
	method varchar(255) not null,
	collection_index_no varchar(255) not null unique,
	description_ja text not null,
	description_original text not null,
	depth int(255) not null,
	width int(255) not null,
	height int(255) not null,
	total_height int(255) not null,
	diameter int(255) not null,
	caliber int(255) not null,
	hill_diameter int(255) not null,
	thickness int(255) not null,
	count int(255) not null,
	created timestamp not null,
	modified timestamp not null,
	foreign key(organization_id) references organizations(organization_id),
	foreign key(collector_id) references collectors(collector_id)
) DEFAULT CHARSET=utf8;
ALTER TABLE documents ADD INDEX index_name(document_id);

create table types(
	type_id int(255) UNSIGNED not null auto_increment primary key,
	name varchar(255) not null,
	class varchar(255) not null
) DEFAULT CHARSET=utf8;
ALTER TABLE types ADD INDEX index_name(type_id);

create table types_relationships(
	types_relationships_id int(255) UNSIGNED not null auto_increment primary key,
	document_id int(255) UNSIGNED not null,
	type_id int(255) UNSIGNED not null,
	foreign key(document_id) references documents(document_id),
	foreign key(type_id) references types(type_id)
) DEFAULT CHARSET=utf8;
ALTER TABLE types_relationships ADD INDEX index_name(types_relationships_id);

create table spaces(
	space_id int(255) UNSIGNED not null auto_increment primary key,
	name varchar(255) not null unique
) DEFAULT CHARSET=utf8;
ALTER TABLE spaces ADD INDEX index_name(space_id);

create table spaces_relationships(
	spaces_relationships_id int(255) UNSIGNED not null auto_increment primary key,
	document_id int(255) UNSIGNED not null ,
	space_id int(255) UNSIGNED not null,
	part varchar(255) not null,
	foreign key(document_id) references documents(document_id),
	foreign key(space_id) references spaces(space_id)
) DEFAULT CHARSET=utf8;
ALTER TABLE spaces_relationships ADD INDEX index_name(spaces_relationships_id);

create table temporals(
	temporal_id int(255) UNSIGNED not null auto_increment primary key,
	name varchar(255) not null unique,
	class varchar(255) not null
) DEFAULT CHARSET=utf8;
ALTER TABLE temporals ADD INDEX index_name(temporal_id);

create table temporals_relationships(
	temporals_relationships_id int(255) UNSIGNED not null auto_increment primary key,
	document_id int(255) UNSIGNED not null,
	temporal_id int(255) UNSIGNED not null,
	foreign key(document_id) references documents(document_id),
	foreign key(temporal_id) references temporals(temporal_id)
) DEFAULT CHARSET=utf8;
ALTER TABLE temporals_relationships ADD INDEX index_name(temporals_relationships_id);

create table creators(
	creator_id int(255) UNSIGNED not null auto_increment primary key,
	name_ja varchar(255) not null,
	name_original varchar(255) not null,
	class varchar(255) not null
) DEFAULT CHARSET=utf8;
ALTER TABLE creators ADD INDEX index_name(creator_id);

create table creators_relationships(
	creators_relationships_id int(255) UNSIGNED not null auto_increment primary key,
	document_id int(255) UNSIGNED not null,
	creator_id int(255) UNSIGNED not null,
	foreign key(document_id) references documents(document_id),
	foreign key(creator_id) references creators(creator_id)
) DEFAULT CHARSET=utf8;
ALTER TABLE creators_relationships ADD INDEX index_name(creators_relationships_id);

create table properties(
	property_id int(255) UNSIGNED not null auto_increment primary key,
	name varchar(255) not null unique,
	class varchar(255) not null
) DEFAULT CHARSET=utf8;
ALTER TABLE properties ADD INDEX index_name(property_id);

create table properties_relationships(
	properties_relationships_id int(255) UNSIGNED not null auto_increment primary key,
	document_id int(255) UNSIGNED not null,
	property_id int(255) UNSIGNED not null,
	foreign key(document_id) references documents(document_id),
	foreign key(property_id) references properties(property_id)
) DEFAULT CHARSET=utf8;
ALTER TABLE properties_relationships ADD INDEX index_name(properties_relationships_id);

create table descriptions(
	description_id int(255) UNSIGNED not null auto_increment primary key,
	content varchar(255) not null unique,
	class varchar(255) not null
) DEFAULT CHARSET=utf8;
ALTER TABLE descriptions ADD INDEX index_name(description_id);

create table descriptions_relationships(
	descriptions_relationships_id int(255) UNSIGNED not null auto_increment primary key,
	document_id int(255) UNSIGNED not null,
	description_id int(255) UNSIGNED not null,
	foreign key(document_id) references documents(document_id),
	foreign key(description_id) references descriptions(description_id)
) DEFAULT CHARSET=utf8;
ALTER TABLE descriptions_relationships ADD INDEX index_name(descriptions_relationships_id);

create table relations(
	relation_id int(255) UNSIGNED not null auto_increment primary key,
	content varchar(255) not null unique,
	class varchar(255) not null
) DEFAULT CHARSET=utf8;
ALTER TABLE relations ADD INDEX index_name(relation_id);

create table relations_relationships(
	relations_relationships_id int(255) UNSIGNED not null auto_increment primary key,
	document_id int(255) UNSIGNED not null,
	relation_id int(255) UNSIGNED not null,
	foreign key(document_id) references documents(document_id),
	foreign key(relation_id) references relations(relation_id)
) DEFAULT CHARSET=utf8;
ALTER TABLE relations_relationships ADD INDEX index_name(relations_relationships_id);

create table research_dates(
	research_date_id int(255) UNSIGNED not null auto_increment primary key,
	document_id int(255) UNSIGNED not null,
	date date not null,
	foreign key(document_id) references documents(document_id)
) DEFAULT CHARSET=utf8;
ALTER TABLE research_dates ADD INDEX index_name(research_date_id);

create table researchers(
	researcher_id int(255) UNSIGNED not null auto_increment primary key,
	name varchar(255) not null unique
) DEFAULT CHARSET=utf8;
ALTER TABLE researchers ADD INDEX index_name(researcher_id);

create table researchers_roles(
	role_id int(255) UNSIGNED not null auto_increment primary key,
	researcher_id int(255) UNSIGNED not null,
	class varchar(255) not null,
	foreign key(researcher_id) references researchers(researcher_id)
) DEFAULT CHARSET=utf8;
ALTER TABLE researchers_roles ADD INDEX index_name(role_id);

create table researchers_roles_relationships(
	researchers_roles_relationships_id int(255) UNSIGNED not null auto_increment primary key,
	research_date_id int(255) UNSIGNED not null,
	role_id int(255) UNSIGNED not null,
	foreign key(research_date_id) references research_dates(research_date_id),
	foreign key(role_id) references researchers_roles(role_id)
) DEFAULT CHARSET=utf8;
ALTER TABLE researchers_roles_relationships ADD INDEX index_name(researchers_roles_relationships_id);