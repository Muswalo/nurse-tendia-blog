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
    public function updateBlogPost($id, $title, $content, $author, $image_url = null, $slug = null, $excerpt = null)
    {
        $sql = "UPDATE blog_posts SET title = :title, content = :content, author = :author, image_url = :image_url, slug = :slug, excerpt = :excerpt WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'title' => $title,
            'content' => $content,
            'author' => $author,
            'image_url' => $image_url,
            'slug' => $slug,
            'excerpt' => $excerpt
        ]);
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
    public function updateEvent($id, $title, $description, $date, $location,  $image_url = null)
    {
        $sql = "UPDATE events SET title = :title, description = :description, date = :date, location = :location, image_url = :image_url WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id, 'title' => $title, 'description' => $description, 'date' => $date, 'location' => $location, 'image_url' => $image_url]);
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
    public function removeEventFeatured($id) {
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
     * @return void
     */
    public function createMetric($user_id)
    {
        $sql = "INSERT INTO metrics (user_id) VALUES (:user_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
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
}
