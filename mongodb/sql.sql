db.categories.aggregate(
    [
        { $unset: "countries" },
        {$match : {sql_id : { $in: [ 64,65,66 ] }}},
        //{$addFields : {sort : { $indexOfArray: [ [64, 65, 66], "$sql_id" ] }}},
        {$sort : {sort : 1}}
    ]
).explain("executionStats");