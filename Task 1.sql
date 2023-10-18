SELECT p.Firstname, p.Surname, e.emailaddress, COUNT(e.emailaddress) as matches
FROM profiles p
JOIN emails e ON p.UserRefID = e.UserRefID
WHERE p.Deceased = 0
GROUP BY e.emailaddress
HAVING SUM(e.Default) = 1;