<?php

namespace Muswalo\NurseTendiaBlog\Controllers;

use Muswalo\NurseTendiaBlog\Database\Database;
use PDO;
use PDOException;

/**
 * Class Controllers
 * 
 * Contains methods for CRUD operations on the database.
 */
class Controllers
{
    /**
     * @var PDO The PDO connection object.
     */
    private PDO $db;

    /**
     * Constructor for the Controllers class.
     */
    public function __construct()
    {
        $this->db = Database::connect();
    }

    // Users CRUD operations

    /**
     * Creates a new user in the database.
     *
     * @param string $username The username of the user.
     * @param string $password The password of the user.
     *
     * @return void
     */
    public function createUser($username, $password)
    {
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['username' => $username, 'password' => password_hash($password, PASSWORD_DEFAULT)]);
    }

    /**
     * Retrieves a user from the database by ID.
     *
     * @param int $id The ID of the user.
     *
     * @return array The user data.
     */
    public function getUser($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves a user from the database by username.
     *
     * @param string $username The username of the user.
     *
     * @return array The user data.
     */
    public function updateUser($id, $username, $password)
    {
        $sql = "UPDATE users SET username = :username, password = :password WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id, 'username' => $username, 'password' => password_hash($password, PASSWORD_DEFAULT)]);
    }

    /**
     * Retrieves a user from the database by username.
     *
     * @param string $username The username of the user.
     *
     * @return array|false The user data, or false if not found.
     */
    public function getUserByUsername($username)
    {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    /**
     * Deletes a user from the database.
     *
     * @param int $id The ID of the user.
     *
     * @return void
     */
    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    // Blog Posts CRUD operations

    /**
     * Creates a new blog post in the database.
     *
     * @param string $title   The title of the blog post.
     * @param string $content The content of the blog post.
     * @param string $author  The author of the blog post.
     * @param int    $user_id The ID of the user who created the blog post.
     * @param string|null $image_url The URL of the image for the blog post.
     * @param int    $featured Whether the blog post is featured or not.
     *
     * @return void
     */
    public function createBlogPost($title, $content, $author, $user_id, $featured, $image_url = null)
    {
        $sql = "INSERT INTO blog_posts (title, content, author, user_id, image_url, featured) VALUES (:title, :content, :author, :user_id, :image_url, :featured)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'title' => $title,
            'content' => $content,
            'author' => $author,
            'user_id' => $user_id,
            'image_url' => $image_url,
            'featured' => $featured,
        ]);
        // Return the ID of the newly inserted blog post
        return $this->db->lastInsertId();
    }

    /**
     * Updates a blog post in the database.
     *
     * @param int    $id       The ID of the blog post.
     * @param string $title    The title of the blog post.
     * @param string $content  The content of the blog post.
     * @param string $author   The author of the blog post.
     * @param string|null $image_url The URL of the image for the blog post.
     * @param string|null $slug The slug of the blog post.
     * @param string|null $excerpt The excerpt of the blog post.
     *
     * @return void
     */

    public function updateBlogPost($id, $title, $content, $author, $featured, $image_url = null)
    {
        try {
            $sql = "UPDATE blog_posts 
                    SET title = :title, 
                        content = :content, 
                        author = :author, 
                        featured = :featured";

            $params = [
                'id' => $id,
                'title' => $title,
                'content' => $content,
                'author' => $author,
                'featured' => $featured,
            ];

            if ($image_url !== null) {
                $sql .= ", image_url = :image_url";
                $params['image_url'] = $image_url;
            }

            $sql .= " WHERE id = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Database update error: " . $e->getMessage());
        }
    }


    /**
     * Retrieves a blog post from the database by ID.
     *
     * @param int $id The ID of the blog post.
     *
     * @return array The blog post data.
     */
    public function getBlogPost($id)
    {
        $sql = "SELECT * FROM blog_posts WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves all blog posts from the database.
     *
     * @return array All blog posts.
     */
    public function getAllBlogPosts()
    {
        $sql = "SELECT * FROM blog_posts ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Deletes a blog post from the database.
     *
     * @param int $id The ID of the blog post.
     *
     * @return void
     */
    public function deleteBlogPost($id)
    {
        $sql = "DELETE FROM blog_posts WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    /**
     * Sets a blog post as featured or not featured.
     *
     * @param int  $id       The ID of the blog post.
     * @param bool $featured Whether the blog post is featured or not.
     *
     * @return void
     */
    public function setBlogPostFeatured($id, $featured)
    {
        $featured = $featured ? 1 : 0;
        $sql = "UPDATE blog_posts SET featured = :featured WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id, 'featured' => $featured]);
    }


    /**
     * Retrieves all featured blog posts from the database.
     *
     * @return array All featured blog posts.
     */
    public function getFeaturedBlogPosts()
    {
        $sql = "SELECT * FROM blog_posts WHERE featured = 1 ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Retrieves suggested posts for a given post ID.
     *
     * @param int $currentPostId The ID of the current post.
     * @param int $limit The maximum number of suggested posts to retrieve.
     *
     * @return array An array of suggested post data.
     */

    public function getSuggestedPosts($currentPostId, $limit = 3)
    {
        try {

            $sql = "SELECT * FROM blog_posts WHERE id != :currentPostId ORDER BY created_at DESC LIMIT :limit";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':currentPostId', $currentPostId, \PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            var_dump($e);
            return [];
        }
    }

    /**
     * Increments the view count for a blog post.
     *
     * @param int $postId The ID of the blog post.
     *
     * @return void
     * @throws PDOException If a database error occurs.
     */
    public function incrementPostViews(int $postId): void
    {
        try {
            $sql = "UPDATE blog_posts SET views = views + 1 WHERE id = :postId";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':postId', $postId, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database Error (incrementPostViews): " . $e->getMessage());
        }
    }

    // Events CRUD operations

    /**
     * Creates a new event in the database.
     *
     * @param string $title       The title of the event.
     * @param string $description The description of the event.
     * @param string $date        The date of the event.
     * @param string $location    The location of the event.
     * @param string|null $image_url The URL of the image for the event.
     *
     * @return void
     */
    public function createEvent($title, $description, $date, $location, $user_id, $featured, $image_url = null)
    {
        $sql = "INSERT INTO events (`title`, `description`, `date`, `location`, `user_id`, `featured`,`image_url`) VALUES (:title, :description, :date, :location, :user_id, :featured, :image_url)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['title' => $title, 'description' => $description, 'date' => $date, 'location' => $location, 'user_id' => $user_id, 'featured' => $featured, 'image_url' => $image_url]);
    }

    /**
     * Retrieves an event from the database by ID.
     *
     * @param int $id The ID of the event.
     *
     * @return array The event data.
     */
    public function getEvent($id)
    {
        $sql = "SELECT * FROM events WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    /**
     * Retrieves all events from the database.
     *
     * @return array All events.
     */
    public function getAllEvents()
    {
        $sql = "SELECT * FROM events ORDER BY `created_at` ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Updates an event in the database.
     *
     * @param int    $id          The ID of the event.
     * @param string $title       The title of the event.
     * @param string $description The description of the event.
     * @param string $date        The date of the event.
     * @param string $location    The location of the event.
     * @param string|null $image_url The URL of the image for the event.
     *
     * @return void
     */
    public function updateEvent($id, $title, $description, $date, $location, $featured, $image_url = null)
    {
        $sql = "UPDATE events SET `title` = :title, `description` = :description, `date` = :date, `location` = :location, `featured` = :featured";

        if ($image_url !== null) {
            $sql .= ", image_url = :image_url";
        }

        $sql .= " WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $params = [
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'date' => $date,
            'location' => $location,
            'featured' => $featured
        ];

        if ($image_url !== null) {
            $params['image_url'] = $image_url;
        }

        $stmt->execute($params);
    }

    /**
     * Deletes an event from the database.
     *
     * @param int $id The ID of the event.
     *
     * @return void
     */
    public function deleteEvent($id)
    {
        $sql = "DELETE FROM events WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }


    /**
     * Sets an event as featured or not featured.
     *
     * @param int  $id The ID of the event.
     * @param bool $featured Whether the event is featured or not.
     *
     * @return void
     */
    public function setEventFeatured($id, $featured)
    {
        $featured = $featured ? 1 : 0;
        $sql = "UPDATE events SET featured = :featured WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id, 'featured' => $featured]);
    }

    /**
     * Retrieves all featured events from the database.
     *
     * @return array All featured events.
     */
    public function getFeaturedEvents()
    {
        $sql = "SELECT * FROM events WHERE featured = 1 ORDER BY `created_at` ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Removes the "featured" status from an event.
     *
     * @param int $id The ID of the event.
     *
     * @return void
     */
    public function removeEventFeatured($id)
    {
        $sql = "UPDATE events SET featured = 0 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    // Metrics CRUD operations

    /**
     * Creates a new metric in the database.
     *
     * @param int $user_id The ID of the user.
     *
     * @return int the record id
     */
    public function createMetric()
    {
        $sql = "INSERT INTO metrics (times_visited) VALUES (:time_visited)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['time_visited' => 1]);
        return $this->db->lastInsertId();
    }

    /**
     * Retrieves a metric from the database by ID.
     *
     * @param int $id The ID of the metric.
     *
     * @return array The metric data.
     */
    public function getMetric($id)
    {
        $sql = "SELECT * FROM metrics WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves a metric from the database by user ID.
     *
     * @param int $user_id The ID of the user.
     *
     * @return array The metric data.
     */
    public function getMetricByUserId($user_id)
    {
        $sql = "SELECT * FROM metrics WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Updates a metric in the database.
     *
     * @param int $id  The ID of the metric.
     * @param int $times_visited The number of times the user has visited the site.
     *
     * @return void
     */
    public function updateMetric($id, $times_visited)
    {
        $sql = "UPDATE metrics SET times_visited = :times_visited, updated_at = CURRENT_TIMESTAMP WHERE id = :id"; // Added updated_at
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id, 'times_visited' => $times_visited]);
    }

    /**
     * Increments the times_visited metric for a user.
     *
     * @param int $user_id The ID of the user.
     *
     * @return void
     */
    public function incrementTimesVisited($user_id)
    {
        // Check if a metric exists for the user
        $metric = $this->getMetricByUserId($user_id);

        if ($metric) {
            // Increment the times_visited
            $newTimesVisited = $metric['times_visited'] + 1;
            $this->updateMetric($metric['id'], $newTimesVisited);
        } else {
            // Create a new metric if it doesn't exist
            $this->createMetric($user_id);
        }
    }

    /**
     * Deletes a metric from the database.
     *
     * @param int $id The ID of the metric.
     *
     * @return void
     */
    public function deleteMetric($id)
    {
        $sql = "DELETE FROM metrics WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    /**
     * Sums the 'times_visited' column in the 'metrics' table.
     *
     * @return int The sum of times_visited.
     */
    public function sumTimesVisited(): int
    {
        try {
            $sql = "SELECT SUM(times_visited) FROM metrics";
            $stmt = $this->db->query($sql);
            return (int)$stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Sums the 'views' column in the 'blog_posts' table.
     *
     * @return int The sum of views.
     */
    public function sumBlogPostViews(): int
    {
        try {
            $sql = "SELECT SUM(views) FROM blog_posts";
            $stmt = $this->db->query($sql);
            return (int)$stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Counts the number of rows in the 'metrics' table.
     *
     * @return int The number of rows.
     */
    public function countMetricsRows(): int
    {
        try {
            $sql = "SELECT COUNT(*) FROM metrics";
            $stmt = $this->db->query($sql);
            return (int)$stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return 0;
        }
    }


    /**
     * Counts the number of rows in the 'blog_posts' table.
     *
     * @return int The number of rows.
     */
    public function countBlogPostsRows(): int
    {
        try {
            $sql = "SELECT COUNT(*) FROM blog_posts";
            $stmt = $this->db->query($sql);
            return (int)$stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return 0;
        }
    }

    // ******** new letter methods

    /**
     * Subscribes an email with a name to the newsletter.
     *
     * @param string $email The email address to subscribe.
     * @param string $name The name of the subscriber.
     * @return bool True if subscription was successful, false otherwise.
     */
    public function subscribeWithName(string $email, string $name): bool
    {
        try {
            $sql = "SELECT 1 FROM newsletter_subscribers WHERE LOWER(email) = LOWER(:email)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['email' => $email]);

            if ($stmt->fetchColumn()) {
                return false;
            }
            $sql = "INSERT INTO newsletter_subscribers (email, name) VALUES (:email, :name)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['email' => $email, 'name' => $name]);
        } catch (PDOException $e) {
            error_log("Database Error (subscribeWithName): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Retrieves all unsubscribed emails from the newsletter_subscribers table.
     *
     * @return array An array of unsubscribed email addresses.
     */
    public function getAllUnsubscribedEmails(): array
    {
        try {
            $sql = "SELECT email FROM newsletter_subscribers WHERE is_subscribed = FALSE";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            error_log("Database Error (getAllUnsubscribedEmails): " . $e->getMessage());
            return [];
        }
    }

    /**
     * Retrieves all subscribed names and emails from the newsletter_subscribers table.
     *
     * @return array An array of associative arrays containing 'name' and 'email' of subscribed users.
     */
    public function getAllSubscribedNamesAndEmails(): array
    {
        try {
            $sql = "SELECT name, email FROM newsletter_subscribers WHERE is_subscribed = TRUE";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database Error (getAllSubscribedNamesAndEmails): " . $e->getMessage());
            return [];
        }
    }
}
