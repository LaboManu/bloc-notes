<%@ page import="java.io.*" %>
<%@ include file="base64.jsp" %>
<html>
<head>
    <title>View saved image</title>
</head>
<body bgcolor="#e0e0e0">
<%
File saveDir = new File(application.getRealPath(request.getServletPath())).getParentFile();
String filename = Long.toString(System.currentTimeMillis()/1000)+".png";

// save the image
String base64EncodedImage = request.getParameter("image_data");
if (base64EncodedImage != null) {
    byte imageBytes[] = base64Decode(base64EncodedImage);
    OutputStream os = new FileOutputStream(new File(saveDir,filename));
    try {
	os.write(imageBytes);

	// show the image on the page
	out.println("<h3>The image has been saved on the server as "+filename+"</h3>");
	out.println("<img src=\""+filename+"\" border=\"1\">");
    }
    finally {
	os.close();
    }
}
else
    out.println("image_data is not found in the request");
%>
</body>
</html>
