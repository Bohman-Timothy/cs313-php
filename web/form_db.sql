/* heroku addons:create heroku-postgresql:hobby-dev */

create table physical_format (
	id						serial primary key not null,
	format					text unique not null,
	created_at				timestamptz default CURRENT_TIMESTAMP not null,
	updated_at				timestamptz default now() not null
);

create table storage_location (
	id						serial primary key not null,
	location				text unique not null,
	created_at				timestamptz default CURRENT_TIMESTAMP not null,
	updated_at				timestamptz default now() not null
);

create table feature_set (
	id						serial primary key not null,
	feature_set_title		text unique not null,
	created_at				timestamptz default CURRENT_TIMESTAMP not null,
	updated_at				timestamptz default now() not null
);

create table feature (
	id						serial primary key not null,
	feature_title			text not null,
	feature_year			smallint not null,
	fk_physical_format		int references physical_format(id) not null,
	format_year				smallint,
	fk_feature_set			int references feature_set(id),
	fk_storage_location		int references storage_location(id),
	existing_loan			boolean default false not null,
	created_at				timestamptz default CURRENT_TIMESTAMP not null,
	updated_at				timestamptz default now() not null
);

create table feature_set_features (
	id						serial primary key not null,
	fk_feature_set			int references feature_set(id) not null,
	fk_feature				int references feature(id) not null,
	created_at				timestamptz default CURRENT_TIMESTAMP not null,
	updated_at				timestamptz default now() not null
);

create table patron (
	id						serial primary key not null,
	username				text unique not null,
	full_name				text not null,
	created_at				timestamptz default CURRENT_TIMESTAMP not null,
	updated_at				timestamptz default now() not null
);

create table loan (
	id						serial primary key not null,
	fk_feature_loaned		int references feature(id) not null,
	fk_borrower				int references patron(id) not null,
	loan_date				timestamptz default now() not null,	
	return_date				timestamptz,
	created_at				timestamptz default CURRENT_TIMESTAMP not null,
	updated_at				timestamptz default now() not null
);


insert into physical_format (format)
	values ('VHS');
insert into physical_format (format)
	values ('DVD');
insert into physical_format (format)
	values ('Blu-ray');
insert into physical_format (format)
	values ('4K Ultra HD Blu-ray');

insert into storage_location (location)
	values ('Bedroom');
insert into storage_location (location)
	values ('Hallway');
insert into storage_location (location)
	values ('Family Room');
insert into storage_location (location)
	values ('Dining Room');
insert into storage_location (location)
	values ('Living Room');

insert into feature (feature_title, feature_year, fk_physical_format, format_year, fk_storage_location)
	values ('Return to Oz', 1985, 2, 1999, 1);

insert into feature_set (feature_set_title)
	values ('Back to the Future 25th Anniversary Trilogy');

insert into feature (feature_title, feature_year, fk_physical_format, format_year, fk_storage_location)
	values ('Tron', 1982, 2, 2002, 1);

insert into feature (feature_title, feature_year, fk_physical_format, format_year, fk_storage_location)
	values ('Wish Upon a Star', 1996, 2, 2001, 1);

insert into feature (feature_title, feature_year, fk_physical_format, format_year, fk_storage_location)
	values ('Freaky Friday', 1976, 2, 2004, 1);

insert into feature (feature_title, feature_year, fk_physical_format, format_year, fk_feature_set, fk_storage_location)
	values ('Back to the Future', 1985, 3, 2011, 1, 1);

insert into feature (feature_title, feature_year, fk_physical_format, format_year, fk_feature_set, fk_storage_location)
	values ('Back to the Future Part II', 1989, 3, 2011, 1, 1);

insert into feature (feature_title, feature_year, fk_physical_format, format_year, fk_feature_set, fk_storage_location)
	values ('Back to the Future Part III', 1990, 3, 2011, 1, 1);

insert into feature (feature_title, feature_year, fk_physical_format, format_year, fk_storage_location)
	values ('Kate & Leopold', 2001, 2, 2002, 2);

insert into feature (feature_title, feature_year, fk_physical_format, format_year, fk_storage_location)
	values ('Shall We Dance?', 2004, 2, 2005, 2);


insert into feature_set (feature_set_title)
	values ('Finding Nemo Collector''s Edition 3-Disc Combo Pack');

insert into feature (feature_title, feature_year, fk_physical_format, format_year, fk_feature_set, fk_storage_location)
	values ('Finding Nemo', 1990, 3, 2012, 2, 1);

insert into feature (feature_title, feature_year, fk_physical_format, format_year, fk_feature_set, fk_storage_location)
	values ('Finding Nemo', 1990, 2, 2012, 2, 1);


insert into patron (username, full_name)
	values ('asquire', 'Timothy Bohman');

insert into patron (username, full_name)
	values ('zherynn', 'Thayne Bohman');


insert into loan (fk_feature_loaned, fk_borrower)
	values (4, 1);

update feature
	set existing_loan = true, updated_at = now()
	where feature.id = 4;

insert into loan (fk_feature_loaned, fk_borrower)
	values (10, 2);

update feature
	set existing_loan = true, updated_at = now()
	where feature.id = 10;


create view feature_view as
	select feature.id, feature.feature_title, feature.feature_year, physical_format.format, feature.format_year, feature_set.feature_set_title, storage_location.location, feature.existing_loan
		from feature
		left join physical_format on feature.fk_physical_format = physical_format.id
		left join storage_location on feature.fk_storage_location = storage_location.id
		left join feature_set on fk_feature_set = feature_set.id;


create view loan_view as
	select loan.id, loan.loan_date, loan.return_date, patron.username, patron.full_name, feature.feature_title, feature.feature_year, physical_format.format, feature.format_year, feature_set.feature_set_title
		from loan
		left join patron on loan.fk_borrower = patron.id
		left join feature on loan.fk_feature_loaned = feature.id
		left join physical_format on feature.fk_physical_format = physical_format.id
		left join feature_set on feature.fk_feature_set = feature_set.id;


create view storage_location_view as
	select storage_location.id, storage_location.location, feature.feature_title, feature.feature_year, physical_format.format, feature.format_year
		from storage_location, feature, physical_format
		where feature.fk_storage_location = storage_location.id and feature.fk_physical_format = physical_format.id;


select * from feature_view;

select * from loan_view;

select *
	from storage_location_view
	where location = 'Bedroom';