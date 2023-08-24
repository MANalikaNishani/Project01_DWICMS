import cv2
import face_recognition
import mysql.connector

# Establish a connection to the MySQL database
conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="designwork"
)

# Create a cursor object to interact with the database
cursor = conn.cursor()

# Retrieve the face encodings and names from the "users" table
query = "SELECT face_encoding, name FROM userlogin"
cursor.execute(query)

# Initialize lists to store the known face encodings and names
known_face_encodings = []
known_face_names = []

# Iterate over the rows returned by the query
for row in cursor:
    # Decode the serialized face encoding
    face_encoding = [float(value) for value in row[0].split(',')]
    
    # Append the face encoding and corresponding name to the lists
    known_face_encodings.append(face_encoding)
    known_face_names.append(row[1])

# Close the cursor and database connection
cursor.close()
conn.close()

# Capture video from webcam
video_capture = cv2.VideoCapture(0)

while True:
    # Capture frame-by-frame
    ret, frame = video_capture.read()

    # Resize frame for faster face recognition (optional)
    small_frame = cv2.resize(frame, (0, 0), fx=0.25, fy=0.25)

    # Convert the image from BGR color (OpenCV default) to RGB color
    rgb_frame = small_frame[:, :, ::-1]

    # Find all face locations and encodings in the current frame
    face_locations = face_recognition.face_locations(rgb_frame)
    face_encodings = face_recognition.face_encodings(rgb_frame, face_locations)

    for face_encoding in face_encodings:
        # Compare the face encoding with known face encodings
        matches = face_recognition.compare_faces(known_face_encodings, face_encoding)
        name = "Unknown"

        # If a match is found, use the known face name
        if True in matches:
            first_match_index = matches.index(True)
            name = known_face_names[first_match_index]

        # Display the recognized name on the frame
        cv2.putText(frame, name, (face_locations[3], face_locations[0] - 10), cv2.FONT_HERSHEY_SIMPLEX, 0.75, (0, 255, 0), 2)

    
    # Display the resulting image
    cv2.imshow('Video', frame)

    # Exit the loop if the 'q' key is pressed
    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

# Release the video capture and close all windows
video_capture.release()
cv2.destroyAllWindows()
