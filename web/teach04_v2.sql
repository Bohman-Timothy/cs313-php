drop table notes;
drop table conference_talks;
drop table users;
drop table conferences;
drop table speakers;


create table users (
    username			text primary key	not null,
    created_at		timestamptz default Now(),
    created_by		int,
    updated_at		timestamptz default Now(),
    updated_by		int
);

create table conferences (
    month_year		text primary key	not null,
    created_at		timestamptz default Now(),
    created_by		int,
    updated_at		timestamptz default Now(),
    updated_by		int
);

create table speakers (
    name			text primary key	not null,
    created_at		timestamptz default Now(),
    created_by		int,
    updated_at		timestamptz default Now(),
    updated_by		int
);

create table conference_talks (
    title			text						not null,
    fk_speaker_name	text	references speakers(name)		not null,
    fk_conf_month_year	text	references conferences(month_year)	not null,
    session			text							not null,
    created_at		timestamptz default Now(),
    created_by		int,
    updated_at		timestamptz default Now(),
    updated_by		int,
    PRIMARY KEY (title, fk_speaker_name, fk_conf_month_year)
);

create table notes (
    id_notes			serial	 primary key					not null,
    text			text							not null,
    fk_conference_title	text	not null,
    fk_speaker_name	text	not null,
    fk_conf_month_year	text	not null,
    fk_user			text	references users(username)		not null,
    created_at		timestamptz default Now(),
    created_by		int,
    updated_at		timestamptz default Now(),
    updated_by		int,
    FOREIGN KEY (fk_conference_title, fk_speaker_name, fk_conf_month_year) REFERENCES conference_talks (title, fk_speaker_name, fk_conf_month_year)
);


insert into conferences (month_year)
	values ('October 2017');


insert into speakers (name)
	values ('David A. Bednar');
insert into speakers
	values ('Russell M. Nelson');
insert into speakers
	values ('Thomas S. Monson');

insert into conference_talks (title, fk_speaker_name, fk_conf_month_year, session)
	values ('Guidance from the Holy Ghost', 'David A. Bednar', 'October 2017', 'Saturday AM');

insert into conference_talks (title, fk_speaker_name, fk_conf_month_year, session)
	values ('Beware of Pride', 'Russell M. Nelson', 'October 2017', 'Priesthood');

insert into conference_talks (title, fk_speaker_name, fk_conf_month_year, session)
	values ('The Power of the Book of Mormon', 'Thomas S. Monson', 'October 2017', 'Sunday AM');

insert into users (username)
	values ('Reed Harston');
insert into users (username)
	values ('Timothy Bohman');

insert into notes (text, fk_conference_title, fk_speaker_name, fk_conf_month_year, fk_user)
	values ('My note', 'Guidance from the Holy Ghost', 'David A. Bednar', 'October 2017', 'Reed Harston');

insert into notes (text, fk_conference_title, fk_speaker_name, fk_conf_month_year, fk_user)
	values ('My note2', 'Beware of Pride', 'Russell M. Nelson', 'October 2017', 'Reed Harston');

insert into notes(text, fk_conference_title, fk_speaker_name, fk_conf_month_year, fk_user)
	values ('My note3', 'Beware of Pride', 'Russell M. Nelson', 'October 2017', 'Reed Harston');

insert into notes(text, fk_conference_title, fk_speaker_name, fk_conf_month_year, fk_user)
	values ('My note4', 'The Power of the Book of Mormon', 'Thomas S. Monson', 'October 2017', 'Timothy Bohman');

insert into notes(text, fk_conference_title, fk_speaker_name, fk_conf_month_year, fk_user)
	values ('My note5', 'Guidance from the Holy Ghost', 'David A. Bednar', 'October 2017', 'Timothy Bohman');

insert into notes(text, fk_conference_title, fk_speaker_name, fk_conf_month_year, fk_user)
	values ('My note6', 'Guidance from the Holy Ghost', 'David A. Bednar', 'October 2017', 'Timothy Bohman');


select * from notes
  where fk_conference_title = 'Guidance from the Holy Ghost'
