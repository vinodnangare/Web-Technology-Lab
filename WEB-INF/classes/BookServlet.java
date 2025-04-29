import java.io.*;
import jakarta.servlet.*;
import jakarta.servlet.http.*;
import java.sql.*;

public class BookServlet extends HttpServlet {

    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

private void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {

    response.setContentType("text/html");
    PrintWriter out = response.getWriter();
    String action = request.getParameter("action");

    try {
        Class.forName("com.mysql.cj.jdbc.Driver");
        Connection con = DriverManager.getConnection(
                "jdbc:mysql://localhost:3306/pradip", "root", "root");

        out.println("<html>");
        out.println("<head><title>Book Management</title><style>");
        out.println("body { font-family: Arial, sans-serif; padding: 20px; }");
        out.println("h3 { color: #4CAF50; }");
        out.println("button { padding: 10px 20px; margin-top: 10px; font-size: 1em; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }");
        out.println("button:hover { background-color: #0056b3; }");
        out.println("table { width: 100%; border-collapse: collapse; margin-top: 20px; }");
        out.println("table, th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }");
        out.println("th { background-color: #f2f2f2; color: #333; }");
        out.println("td { background-color: #f9f9f9; }");
        out.println("</style></head>");
        out.println("<body>");

        if ("insert".equalsIgnoreCase(action)) {
            int id = Integer.parseInt(request.getParameter("id"));
            String title = request.getParameter("title");
            String author = request.getParameter("author");
            double price = Double.parseDouble(request.getParameter("price"));
            int qty = Integer.parseInt(request.getParameter("qty"));

            String sql = "INSERT INTO mybooks VALUES (?, ?, ?, ?, ?)";
            PreparedStatement ps = con.prepareStatement(sql);
            ps.setInt(1, id);
            ps.setString(2, title);
            ps.setString(3, author);
            ps.setDouble(4, price);
            ps.setInt(5, qty);

            int result = ps.executeUpdate();
            out.println("<h3>" + (result > 0 ? "Book inserted successfully" : "Failed to insert book.") + "</h3>");
            ps.close();

        } else if ("delete".equalsIgnoreCase(action)) {
            int id = Integer.parseInt(request.getParameter("id"));
            String sql = "DELETE FROM mybooks WHERE id = ?";
            PreparedStatement ps = con.prepareStatement(sql);
            ps.setInt(1, id);

            int result = ps.executeUpdate();
            out.println("<h3>" + (result > 0 ? "Book deleted successfully!" : "Book not found.") + "</h3>");
            ps.close();

        } else if ("update".equalsIgnoreCase(action)) {
            int id = Integer.parseInt(request.getParameter("id"));
            String title = request.getParameter("title");
            String author = request.getParameter("author");
            double price = Double.parseDouble(request.getParameter("price"));
            int qty = Integer.parseInt(request.getParameter("qty"));

            String sql = "UPDATE mybooks SET title=?, author=?, price=?, quantity=? WHERE id=?";
            PreparedStatement ps = con.prepareStatement(sql);
            ps.setString(1, title);
            ps.setString(2, author);
            ps.setDouble(3, price);
            ps.setInt(4, qty);
            ps.setInt(5, id);

            int result = ps.executeUpdate();
            out.println("<h3>" + (result > 0 ? "Book updated successfully!" : "Book not found.") + "</h3>");
            ps.close();

        } else if ("display".equalsIgnoreCase(action)) {
            String sql = "SELECT * FROM mybooks";
            Statement stmt = con.createStatement();
            ResultSet rs = stmt.executeQuery(sql);

            out.println("<h3>Book List:</h3>");
            out.println("<table><tr><th>ID</th><th>Title</th><th>Author</th><th>Price</th><th>Quantity</th></tr>");
            while (rs.next()) {
                out.println("<tr><td>" + rs.getInt("id") + "</td><td>" +
                        rs.getString("title") + "</td><td>" +
                        rs.getString("author") + "</td><td>" +
                        rs.getDouble("price") + "</td><td>" +
                        rs.getInt("quantity") + "</td></tr>");
            }
            out.println("</table>");
            rs.close();
            stmt.close();
        } else {
            out.println("<h3>Invalid action!</h3>");
        }

        // Ensure the "Back" button is rendered last
        out.println("<br><a href='index.html'><button>Back</button></a>");

        out.println("</body></html>");

        con.close();

    } catch (Exception e) {
        out.println("<h3>Error: " + e.getMessage() + "</h3>");
        e.printStackTrace(out);
    }
}
}
