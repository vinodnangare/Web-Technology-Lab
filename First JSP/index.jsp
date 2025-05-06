<%@ page session="false" %>
<%@ page import="java.sql.*" %>
<html>
<head>
    <title>Book List</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { border-collapse: collapse; width: 80%; margin: auto; }
        th, td { border: 2px solid #4CAF50; padding: 10px; text-align: center; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        h1, h2 { text-align: center; color: #2e6da4; }
    </style>
</head>
<body>

<% out.print("<h2>Hello World !! Welcome to JSP</h2>"); %>
<h1>Welcome to Sanjivani College of Engineering, IT Department</h1>
<h2>Book Details</h2>

<table>
<tr>
    <th>Book ID</th>
    <th>Title</th>
    <th>Author</th>
    <th>Price</th>
    <th>Quantity</th>
</tr>

<%
try { 
    Class.forName("com.mysql.cj.jdbc.Driver"); // Updated driver
    Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/pradip", "root", "root");
    Statement stmt = con.createStatement();
    ResultSet rs = stmt.executeQuery("SELECT * FROM mybooks");

    while (rs.next()) {
        out.println("<tr>");
        out.println("<td>" + rs.getInt("id") + "</td>");
        out.println("<td>" + rs.getString("title") + "</td>");
        out.println("<td>" + rs.getString("author") + "</td>");
        out.println("<td>" + rs.getDouble("price") + "</td>");
        out.println("<td>" + rs.getInt("quantity") + "</td>");
        out.println("</tr>");
    }
    con.close();
} catch (Exception e) { 
    out.print("<tr><td colspan='5' style='color:red;'>" + e.getMessage() + "</td></tr>"); 
}
%>

</table>

</body>
</html>
