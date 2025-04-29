import javax.servlet.http.*;  
import javax.servlet.*;  
import java.io.*; 
import java.sql.*; 

public class DemoServlet extends HttpServlet {  
    public void doGet(HttpServletRequest req, HttpServletResponse res)  
        throws ServletException, IOException {  

        res.setContentType("text/html");  
        PrintWriter pw = res.getWriter();  

        pw.println("<html><body>");  
        pw.println("<h2>Welcome to Pragati eBookShop</h2>");  
        pw.println("<table border='5'>");  
        pw.println("<tr><th>Book ID</th><th>Title</th><th>Author</th><th>Price</th><th>Quantity</th></tr>");  

        try {  
            // Load driver
            Class.forName("com.mysql.cj.jdbc.Driver");  

            // Connect to database
            Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/pragati", "root", "");  

            // Prepare statement
            String sql = "INSERT INTO ebookshop VALUES (?, ?, ?, ?, ?)";  
            PreparedStatement ps = con.prepareStatement(sql);  
            ps.setInt(1, 103);  
            ps.setString(2, "ML");  
            ps.setString(3, "Thomas");  
            ps.setDouble(4, 700.0);  
            ps.setInt(5, 15);  

            // Execute update
            int result = ps.executeUpdate();  

            if (result > 0) {
                pw.println("<tr><td colspan='5'>Record inserted successfully</td></tr>");
            } else {
                pw.println("<tr><td colspan='5'>Insert failed</td></tr>");
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
