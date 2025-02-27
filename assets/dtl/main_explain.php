### **🚤 Explanation of `check_boat_availability()` in Simple Terms**

This function **checks if a boat is available for booking** based on the date and time the user selects. It ensures:  
✅ The boat is **not already booked**.  
✅ The selected time falls within the boat’s **available schedule** (weekday/weekend).  
✅ There is at least **a 90-minute gap after the last booking**.  

---

## **🔍 Step-by-Step Breakdown**

### **  1️⃣ Determine if it's a Weekday or Weekend**
```php
$day_of_week = date('N', strtotime($booking_date)); // 1 = Monday, 7 = Sunday
$availability_type = ($day_of_week >= 6) ? 'weekend' : 'weekday';
```
👉 We **get the day of the week** from the selected booking date.  
👉 If it's **Saturday (6) or Sunday (7)** → it's a **weekend**.  
👉 Otherwise, it's a **weekday**.  

---

### **2️⃣ Check if the Boat is Already Booked**
```php
$this->db->select('COUNT(*) as total');
$this->db->from('boat_bookings');
$this->db->where('boat_id', $boat_id);
$this->db->where('booking_date', $booking_date);
$this->db->where("(
    (booking_start_time BETWEEN '$start_time' AND '$end_time') 
    OR (booking_end_time BETWEEN '$start_time' AND '$end_time') 
    OR ('$start_time' BETWEEN booking_start_time AND booking_end_time)
    OR ('$end_time' BETWEEN booking_start_time AND booking_end_time)
)", NULL, FALSE);
$booking_conflict = $this->db->get()->row()->total;
```
🔹 **What does this do?**  
✅ It **checks the `boat_bookings` table** to see if the boat is **already booked** for the selected date and time.  
✅ If there is an **overlap with an existing booking**, it sets `$booking_conflict > 0`.  

📌 **Booking Conflicts are checked using 4 conditions:**  
- If **any part of the selected time** falls **within an existing booking**.  
- If **an existing booking falls within the selected time**.  

🔹 **Example:**  
| **Existing Booking** | **Requested Booking** | **Conflict?** |
|------------------|----------------|-------------|
| 10:00 AM - 12:00 PM | 11:00 AM - 1:00 PM | ✅ Yes |
| 2:00 PM - 4:00 PM | 4:30 PM - 6:30 PM | ❌ No |
| 6:00 PM - 8:00 PM | 7:00 PM - 9:00 PM | ✅ Yes |

---

### **3️⃣ Check if the Boat is Available at That Time**
```php
$this->db->select('COUNT(*) as total');
$this->db->from('boat_availability');
$this->db->where('boat_id', $boat_id);
$this->db->where('availability_type', $availability_type);
$this->db->where('start_time <=', $start_time);
$this->db->where('end_time >=', $end_time);
$schedule_conflict = $this->db->get()->row()->total;
```
🔹 **What does this do?**  
✅ It **checks the `boat_availability` table** to see if the boat is available during the selected time.  
✅ It **compares the requested time** (`$start_time` and `$end_time`) with the **boat’s available hours** (weekday/weekend).  

📌 **Example of `boat_availability` Table**  
| **Boat ID** | **Availability Type** | **Start Time** | **End Time** |
|------------|-------------------|------------|---------|
| 1          | weekday           | 08:00 AM   | 06:00 PM |
| 1          | weekend           | 09:00 AM   | 08:00 PM |

✅ If you try to book **7:00 AM - 9:00 AM on a weekday**, it's **not available**.  
✅ If you try to book **10:00 AM - 12:00 PM on a weekday**, it's **available**.  

---

### **4️⃣ Ensure a 90-Minute Gap After the Last Booking**
```php
$this->db->select('booking_end_time');
$this->db->from('boat_bookings');
$this->db->where('boat_id', $boat_id);
$this->db->where('booking_date', $booking_date);
$this->db->order_by('booking_end_time', 'DESC');
$this->db->limit(1);
$last_booking = $this->db->get()->row();
```
🔹 **What does this do?**  
✅ It **finds the most recent booking** for the selected boat on the selected date.  
✅ If there was a **previous booking**, it checks if the new booking starts at least **90 minutes after**.  

---

### **5️⃣ Check the Time Gap**
```php
if ($last_booking) {
    $last_end_time = $last_booking->end_time;
    $time_difference = strtotime($start_time) - strtotime($last_end_time);
    if ($time_difference < 90 * 60) { // Less than 90 minutes
        return false;
    }
}
```
🔹 **What does this do?**  
✅ It **calculates the time gap** between the **last booking’s end time** and the **new booking’s start time**.  
✅ If the gap is **less than 90 minutes**, the function **returns false** (boat is unavailable).  

📌 **Example:**  
| **Last Booking End Time** | **Requested Start Time** | **Time Gap** | **Allowed?** |
|---------------------|-----------------|----------|----------|
| 10:00 AM           | 10:30 AM         | 30 min   | ❌ No |
| 11:00 AM           | 12:45 PM         | 105 min  | ✅ Yes |

---

### **6️⃣ Return Final Availability**
```php
return ($booking_conflict == 0 && $schedule_conflict > 0);
```
🔹 **What does this do?**  
✅ If **the boat is NOT already booked** (`$booking_conflict == 0`).  
✅ AND **the selected time is within the boat's schedule** (`$schedule_conflict > 0`).  
✅ Then **the boat is available** (`return true`).  
✅ Otherwise, **it's unavailable** (`return false`).  

---

## **🎯 Summary**
1️⃣ **Check if it's a weekday or weekend.**  
2️⃣ **Make sure the boat is NOT already booked** at the requested time.  
3️⃣ **Verify that the selected time is within the boat’s available hours.**  
4️⃣ **Ensure there’s a 90-minute gap after the last booking.**  
5️⃣ **If all conditions are met, allow the booking.**  

---

## **🛠️ Example Scenarios**
| **Boat ID** | **Booking Date** | **Requested Start Time** | **Requested End Time** | **Allowed?** | **Reason** |
|------------|---------------|-----------------|---------------|-----------|---------|
| 1          | 2024-02-27    | 10:00 AM        | 12:00 PM      | ✅ Yes   | Available on a weekday |
| 1          | 2024-02-27    | 11:00 AM        | 01:00 PM      | ❌ No   | Overlaps with existing booking |
| 1          | 2024-02-27    | 06:30 PM        | 08:30 PM      | ❌ No   | Outside boat availability time |
| 2          | 2024-02-28    | 03:00 PM        | 05:00 PM      | ✅ Yes   | Meets all conditions |

🚀 **Now, you fully understand how boat availability is checked!** Let me know if you have any doubts! 😊