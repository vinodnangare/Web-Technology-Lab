import jakarta.servlet.http.*;  
import jakarta.servlet.*;  
import java.io.*; 
import java.sql.*; 

public class DemoServlet extends HttpServlet {  
    public void doGet(HttpServletRequest req, HttpServletResponse res)  
        throws ServletException, IOException {  
        
        res.setContentType("text/html");
        PrintWriter pw = res.getWriter();

        pw.println("<html><body>");
        pw.println("<h2>Welcome to Pragati eBookShop</h2>");
        pw.println("<table border='1' cellpadding='10'>");  
        pw.println("<tr><th>Book ID</th><th>Title</th><th>Author</th><th>Price</th><th>Quantity</th></tr>");

        try { 
            Class.forName("com.mysql.cj.jdbc.Driver");
            Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/pradip", "root", "root");

            Statement stmt = con.createStatement();
            ResultSet rs = stmt.executeQuery("SELECT * FROM mybooks");

            while (rs.next()) {
                pw.println("<tr><td>" + rs.getInt("id") + "</td>"
                             + "<td>" + rs.getString("title") + "</td>"
                             + "<td>" + rs.getString("author") + "</td>"
                             + "<td>" + rs.getDouble("price") + "</td>"
                             + "<td>" + rs.getInt("quantity") + "</td></tr>");
            }

            con.close();
        } catch(Exception e) {
            pw.println("<tr><td colspan='5'>Error: " + e.getMessage() + "</td></tr>");
        } 

        pw.println("</table>");
        pw.println("</body></html>");    
        pw.close(); 
    }
}
