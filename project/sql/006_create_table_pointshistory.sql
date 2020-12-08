CREATE TABLE PointsHistory
(
    id            int auto_increment,
    user_id       int,
    points_change int,
    reason        varchar(60), -- added a pointshistory table to have points be added to the user
    created       datetime default current_timestamp,
    primary key (id),
    foreign key (user_id) references Users (id)
)
