<%@ page session="false" %>
<%@ page import="java.sql.*" %>
<html>
<head>
    <title>Book Management</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 2px solid black; padding: 10px; text-align: center; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: white; }
        h1, h2 { text-align: center; color: black; }
        form { text-align: center; margin-top: 20px; }
        input, button { margin: 5px; padding: 7px; font-size: 14px; }
        .message { text-align: center; margin: 10px; font-weight: bold; }
    </style>
</head>
<body>

<h1>Welcome to Sanjivani College of Engineering, IT Department</h1>
<h2>Book Management System</h2>

<!-- Form to Insert Book -->
<h2>Insert New Book</h2>
<form method="post">
    <input type="number" name="id" placeholder="Book ID" required>
    <input type="text" name="title" placeholder="Title" required>
    <input type="text" name="author" placeholder="Author" required>
    <input type="number" step="0.01" name="price" placeholder="Price" required>
    <input type="number" name="quantity" placeholder="Quantity" required>
    <button type="submit" name="action" value="insert">Insert Book</button>
</form>

<!-- Form to Delete Book -->
<h2>Delete Book</h2>
<form method="post">
    <input type="number" name="deleteId" placeholder="Book ID to delete" required>
    <button type="submit" name="action" value="delete">Delete Book</button>
</form>

<%
String message = "";
try {
    Class.forName("com.mysql.cj.jdbc.Driver");
    Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/pradip", "root", "root");

    String action = request.getParameter("action");

    // Insert a book
    if ("insert".equals(action)) {
        int id = Integer.parseInt(request.getParameter("id"));
        String title = request.getParameter("title");
        String author = request.getParameter("author");
        double price = Double.parseDouble(request.getParameter("price"));
        int quantity = Integer.parseInt(request.getParameter("quantity"));

        PreparedStatement ps = con.prepareStatement("INSERT INTO mybooks (id, title, author, price, quantity) VALUES (?, ?, ?, ?, ?)");
        ps.setInt(1, id);
        ps.setString(2, title);
        ps.setString(3, author);
        ps.setDouble(4, price);
        ps.setInt(5, quantity);

        int inserted = ps.executeUpdate();
        if (inserted > 0) {
            message = "<p class='message' style='color:green;'>Book inserted successfully!</p>";
        } else {
            message = "<p class='message' style='color:red;'>Failed to insert book.</p>";
        }
    }

    // Delete a book
    if ("delete".equals(action)) {
        int deleteId = Integer.parseInt(request.getParameter("deleteId"));

        PreparedStatement ps = con.prepareStatement("DELETE FROM mybooks WHERE id = ?");
        ps.setInt(1, deleteId);

        int deleted = ps.executeUpdate();
        if (deleted > 0) {
            message = "<p class='message' style='color:green;'>Book deleted successfully!</p>";
        } else {
            message = "<p class='message' style='color:red;'>Book with ID " + deleteId + " not found.</p>";
        }
    }

    // Show success or error message
    out.print(message);

    // Display all books
%>

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
    Statement stmt = con.createStatement();
    ResultSet rs = stmt.executeQuery("SELECT * FROM mybooks");

    while (rs.next()) {
%>
<tr>
    <td><%= rs.getInt("id") %></td>
    <td><%= rs.getString("title") %></td>
    <td><%= rs.getString("author") %></td>
    <td><%= rs.getDouble("price") %></td>
    <td><%= rs.getInt("quantity") %></td>
</tr>
<%
    }

    con.close();
} catch (Exception e) {
    out.println("<p class='message' style='color:red;'>Error: " + e.getMessage() + "</p>");
}
%>

</table>

</body>
</html>
