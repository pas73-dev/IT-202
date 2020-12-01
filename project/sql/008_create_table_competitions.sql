CREATE TABLE Competitions
(
    id   int auto_increment,
    name varchar(60) default '',
    created TIMESTAMP default current_timestamp,
    duration int,
    expires int,
    reward int,
    cost int,
    participants int,
    paid_out int,
    min_score int,
    first_place_per varchar(60) default '',
    second_place_per varchar(60) default '',
    third_place_per varchar(60) default '',
    fee int,
    primary key (id),
    references Users (id)
)
