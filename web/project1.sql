/* CS 313 Project 1: Movie and TV Feature Lending Library*/

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

-- I ended up not using this table
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


-- This view was used only for testing purposes
create view storage_location_view as
  select storage_location.id, storage_location.location, feature.feature_title, feature.feature_year, physical_format.format, feature.format_year
  from storage_location, feature, physical_format
  where feature.fk_storage_location = storage_location.id and feature.fk_physical_format = physical_format.id;


ALTER TABLE patron
  ADD password text;

CREATE TABLE current_loan (
  id         serial primary key                          not null,
  fk_feature int references feature (id) unique          not null,
  fk_loan    int references loan (id) unique,
  created_at timestamptz default CURRENT_TIMESTAMP       not null,
  updated_at timestamptz default now()                   not null
);


BEGIN;
ALTER TABLE loan ADD COLUMN fk_updated_by INT REFERENCES patron (id);
UPDATE loan SET fk_updated_by = 1; -- Set user to asquire
ALTER TABLE loan ALTER COLUMN fk_updated_by SET NOT NULL;
COMMIT;

ALTER TABLE feature ADD COLUMN fk_created_by INT REFERENCES patron (id);
ALTER TABLE feature ADD COLUMN fk_updated_by INT REFERENCES patron (id);
UPDATE feature SET fk_created_by = 1; -- Set user to asquire
UPDATE feature SET fk_updated_by = 1; -- Set user to asquire
ALTER TABLE feature ALTER COLUMN fk_created_by SET NOT NULL;
ALTER TABLE feature ALTER COLUMN fk_updated_by SET NOT NULL;


create view feature_view as
  SELECT feature.id,
         feature.feature_title,
         feature.feature_year,
         physical_format.format,
         feature.format_year,
         COALESCE(feature_set.feature_set_title, '(N/A)' :: text) AS feature_set_title,
         storage_location.location,
         CASE
           WHEN (current_loan.fk_loan IS NOT NULL) THEN 'Yes' :: character varying
           WHEN (current_loan.fk_loan IS NULL) THEN 'No' :: character varying
           ELSE (current_loan.fk_loan) :: character varying(10)
             END                                                  AS existing_loan
  FROM feature
         LEFT JOIN physical_format ON feature.fk_physical_format = physical_format.id
         LEFT JOIN storage_location ON feature.fk_storage_location = storage_location.id
         LEFT JOIN feature_set ON feature.fk_feature_set = feature_set.id
         LEFT JOIN current_loan ON feature.id = current_loan.fk_feature;

ALTER TABLE feature
  DROP COLUMN existing_loan;


create view loan_view as
  select loan.id, to_char(loan.loan_date, 'YYYY/MM/DD HH12:MI:SS AM') AS loan_date, to_char(loan.return_date, 'YYYY/MM/DD HH12:MI:SS AM') AS return_date, patron.username, patron.full_name, feature.feature_title, feature.feature_year, physical_format.format, feature.format_year, COALESCE(feature_set.feature_set_title, '(N/A)' :: text) AS feature_set_title
  from loan
         left join patron on loan.fk_borrower = patron.id
         left join feature on loan.fk_feature_loaned = feature.id
         left join physical_format on feature.fk_physical_format = physical_format.id
         left join feature_set on feature.fk_feature_set = feature_set.id;


create view current_loan_view as
  select loan.id, to_char(loan.loan_date, 'YYYY/MM/DD HH12:MI:SS AM') AS loan_date, to_char(loan.return_date, 'YYYY/MM/DD HH12:MI:SS AM') AS return_date, patron.username, patron.full_name, feature.feature_title, feature.feature_year, physical_format.format, feature.format_year, COALESCE(feature_set.feature_set_title, '(N/A)' :: text) AS feature_set_title
  from loan
         inner join current_loan on loan.id = current_loan.fk_loan
         left join patron on loan.fk_borrower = patron.id
         left join feature on loan.fk_feature_loaned = feature.id
         left join physical_format on feature.fk_physical_format = physical_format.id
         left join feature_set on feature.fk_feature_set = feature_set.id;