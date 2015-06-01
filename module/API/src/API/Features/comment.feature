Feature:
  In order to handle comments
  As a api maintainer
  I should be able to add/list comment through a REST calls

  @comment
  Scenario: add a new comment
    Given I have 2 'Beach' on my system
    And there are 0 'Comment' in the system
    When I send a POST request to "/comment" with image:
      | beach_id    | 1                                      |
      | name        | Gandalf                                |
      | lastName    | Grey                                   |
      | description | beautiful beach carved betwen 2 cliffs |
    Then the response code should be 201
    And the response should contain json:
    """
    { "entity": {
        "id": 1,
        "name": "Gandalf",
        "lastName": "Grey",
        "description": "beautiful beach carved betwen 2 cliffs",
        "beach": {
            "id": 1,
            "name": "Bay Beach",
            "city": "San Francisco"
        },
        "image": "http://dream-beach.local/image/comment/1.jpg"
    }
}
    """
    And there are 1 'Comment' in the system

  @comment
  Scenario: display a list of comments
    Given I have 2 'Comment' on my system
    When I send a GET request to "/comment"
    Then the response code should be 200
    And the response should contain json:
    """
   [
    {
        "id": 1,
        "name": "Gus",
        "lastName": "Mc Duck",
        "description": "test",
        "beach": {
            "id": 1,
            "name": "Bay Beach",
            "city": "San Francisco"
        },
        "image": "http://dream-beach.local/image/comment/1.jpg"
    },
    {
        "id": 2,
        "name": "Mimmo",
        "lastName": "Rossi",
        "description": "test",
        "beach": {
            "id": 2,
            "name": "Palermo Beach",
            "city": "Palermo"
        },
        "image": "http://dream-beach.local/image/comment/2.jpg"
    }
]
    """

  @comment
  Scenario: search comments by city
    Given I have 2 'Comment' on my system
    And 1 of it is from a beach from "Sicily"
    When I send a GET request to "/comment?city=2"
    Then the response code should be 200
    And the response should contain json:
    """
  [
    {
        "id": 2,
        "name": "Mimmo",
        "lastName": "Rossi",
        "description": "test",
        "beach": {
            "id": 2,
            "name": "Palermo Beach",
            "city": "Palermo"
        },
        "image": "http://dream-beach.local/image/comment/2.jpg"
    }
]
    """