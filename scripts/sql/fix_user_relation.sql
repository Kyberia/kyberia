# Fix missing user relation data

## Bookmarks (relation_type = 1)
INSERT INTO user_relation (user_id, node_id, relation_type)
SELECT na.user_id, na.node_id, 1
FROM node_access na
LEFT JOIN user_relation ur ON ur.user_id = na.user_id
                          AND ur.node_id = na.node_id
                          AND ur.relation_type = 1
WHERE na.node_bookmark = 'yes'
  AND ur.node_id IS NULL;

## Friends (relation_type = 2)
INSERT INTO user_relation (user_id, node_id, relation_type)
SELECT n.node_creator, n.node_parent, 2
FROM nodes n
LEFT JOIN user_relation ur ON ur.user_id = n.node_creator
                          AND ur.node_id = n.node_parent
                          AND ur.relation_type = 2
WHERE n.external_link = 'session://friend'
  AND ur.user_id IS NULL
GROUP BY n.node_creator, n.node_parent;
