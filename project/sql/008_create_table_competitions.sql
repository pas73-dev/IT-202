CREATE TABLE IF NOT EXISTS 'Competitions'
(
    id int auto_increment,
    name varchar(60),
    created TIMESTAMP default current_timestamp,
    duration int default 7,
    expires timestamp,
    reward int default 0,
    cost int,
    participants int default 0,
    paid_out boolean,
    points int,
    min_score int default 0,
    first_place_per int default 0,
    second_place_per int default 0,
    third_place_per int default 0,
    inc_points int default 1,
    percent float default .5,
    fee int default 0,
    primary key (id)
)
